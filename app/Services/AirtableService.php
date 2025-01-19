<?php

namespace App\Services;

use App\Models\AirtableSource;
use App\Models\Company;
use App\Models\JobPosition;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AirtableService
{
    private const API_URL = 'https://api.airtable.com/v0';

    public function syncJobPositions(AirtableSource $source): void
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $source->api_key,
        ])->get(self::API_URL . "/{$source->base_id}/{$source->table_id}", [
            'filterByFormula' => "IS_AFTER(CREATED_TIME(), DATEADD(NOW(), -1, 'days'))",
        ]);

        if (!$response->successful()) {
            throw new \Exception('Failed to fetch data from Airtable: ' . $response->body());
        }

        $records = $response->json()['records'] ?? [];

        foreach ($records as $record) {
            $fields = $record['fields'];

            // Create or update company
            $company = Company::firstOrCreate(
                ['name' => $fields['Company'] ?? 'Unknown Company'],
                [
                    'website' => $fields['Company Website'] ?? null,
                    'location' => $fields['Location'] ?? null,
                ]
            );

            // Create job position if it doesn't exist
            JobPosition::firstOrCreate(
                [
                    'title' => $fields['Position'] ?? 'Unknown Position',
                    'company_id' => $company->id,
                ],
                [
                    'slug' => Str::slug($fields['Position'] . '-' . $company->name . '-' . Str::random(6)),
                    'description' => $fields['Description'] ?? '',
                    'requirements' => $fields['Requirements'] ?? '',
                    'location' => $fields['Location'] ?? '',
                    'salary_min' => $this->parseSalaryMin($fields['Salary Range'] ?? ''),
                    'salary_max' => $this->parseSalaryMax($fields['Salary Range'] ?? ''),
                    'type' => $this->parseJobType($fields['Type'] ?? ''),
                ]
            );
        }

        $source->update(['last_synced_at' => now()]);
    }

    private function parseSalaryMin(string $salaryRange): ?int
    {
        if (empty($salaryRange)) {
            return null;
        }

        preg_match('/\$?(\d+)k?/i', $salaryRange, $matches);
        return isset($matches[1]) ? (int) $matches[1] * 1000 : null;
    }

    private function parseSalaryMax(string $salaryRange): ?int
    {
        if (empty($salaryRange)) {
            return null;
        }

        preg_match('/\$?(\d+)k?.*-.*\$?(\d+)k?/i', $salaryRange, $matches);
        return isset($matches[2]) ? (int) $matches[2] * 1000 : null;
    }

    private function parseJobType(string $type): string
    {
        $type = strtolower($type);

        if (str_contains($type, 'full')) {
            return 'full_time';
        }

        if (str_contains($type, 'part')) {
            return 'part_time';
        }

        if (str_contains($type, 'contract')) {
            return 'contract';
        }

        return 'full_time';
    }
}

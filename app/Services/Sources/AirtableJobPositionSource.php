<?php

namespace App\Services\Sources;

use App\Models\JobPositionSource;
use App\Services\AbstractJobPositionSource;
use Illuminate\Support\Facades\Http;

class AirtableJobPositionSource extends AbstractJobPositionSource
{
    private const API_URL = 'https://api.airtable.com/v0';

    public function sync(JobPositionSource $source): void
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $source->credentials['api_key'],
        ])->get(self::API_URL . "/{$source->credentials['base_id']}/{$source->credentials['table_id']}", [
            'filterByFormula' => "IS_AFTER(CREATED_TIME(), DATEADD(NOW(), -1, 'days'))",
        ]);

        if (!$response->successful()) {
            throw new \Exception('Failed to fetch data from Airtable: ' . $response->body());
        }

        $records = $response->json()['records'] ?? [];

        foreach ($records as $record) {
            $fields = $record['fields'];

            $this->createOrUpdateJobPosition([
                'title' => $fields['Position'] ?? 'Unknown Position',
                'company_name' => $fields['Company'] ?? 'Unknown Company',
                'company_website' => $fields['Company Website'] ?? null,
                'company_location' => $fields['Location'] ?? null,
                'description' => $fields['Description'] ?? '',
                'requirements' => $fields['Requirements'] ?? '',
                'benefits' => $fields['Benefits'] ?? '',
                'location' => $fields['Location'] ?? '',
                'salary_min' => $this->parseSalaryMin($fields['Salary Range'] ?? ''),
                'salary_max' => $this->parseSalaryMax($fields['Salary Range'] ?? ''),
                'type' => $this->parseJobType($fields['Type'] ?? ''),
            ]);
        }

        $this->updateLastSynced($source);
    }

    public function validateCredentials(array $credentials): bool
    {
        if (!isset($credentials['api_key'], $credentials['base_id'], $credentials['table_id'])) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $credentials['api_key'],
            ])->get(self::API_URL . "/{$credentials['base_id']}/{$credentials['table_id']}", [
                'maxRecords' => 1,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
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

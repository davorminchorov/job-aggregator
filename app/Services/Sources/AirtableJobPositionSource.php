<?php

namespace App\Services\Sources;

use App\Models\JobPositionSource;
use App\Services\AbstractJobPositionSource;
use App\Services\Airtable\AirtableClient;
use App\Services\Airtable\AirtableException;

class AirtableJobPositionSource extends AbstractJobPositionSource
{
    private ?AirtableClient $client = null;

    public function sync(JobPositionSource $source): void
    {
        try {
            $records = $this->getClient($source->credentials['pat'])
                ->listRecords($source->credentials['base_id'], $source->credentials['table_id']);

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
        } catch (AirtableException $e) {
            throw new \Exception('Failed to sync job positions: ' . $e->getMessage());
        }
    }

    public function validateCredentials(array $credentials): bool
    {
        if (! isset($credentials['pat'], $credentials['base_id'], $credentials['table_id'])) {
            return false;
        }

        try {
            return $this->getClient($credentials['pat'])
                ->validateAccess($credentials['base_id'], $credentials['table_id']);
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

        if (str_contains($type, 'freelance')) {
            return 'freelance';
        }

        if (str_contains($type, 'intern')) {
            return 'internship';
        }

        return 'full_time';
    }

    private function getClient(string $pat): AirtableClient
    {
        if ($this->client === null) {
            $this->client = new AirtableClient($pat);
        }

        return $this->client;
    }
}

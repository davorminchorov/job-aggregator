<?php

namespace App\Services\Airtable;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class AirtableClient
{
    private const API_URL = 'https://api.airtable.com/v0';

    private PendingRequest $client;

    public function __construct(string $pat)
    {
        $this->client = Http::withHeaders([
            'Authorization' => 'Bearer ' . trim($pat),
            'Content-Type' => 'application/json',
        ])->baseUrl(self::API_URL);
    }

    public function listRecords(string $baseId, string $tableId, array $params = []): array
    {
        $response = $this->client->get(
            sprintf('/%s/%s', trim($baseId), trim($tableId)),
            array_merge([
                'maxRecords' => 100,
                'view' => 'Grid view',
            ], $params)
        );

        if (! $response->successful()) {
            $error = $response->json();
            throw new AirtableException(
                'Failed to fetch records from Airtable: ' . ($error['error']['message'] ?? $response->body())
            );
        }

        return $response->json()['records'] ?? [];
    }

    public function validateAccess(string $baseId, string $tableId): bool
    {
        try {
            $response = $this->client->get(
                sprintf('/%s/%s', trim($baseId), trim($tableId)),
                ['maxRecords' => 1]
            );

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}

<?php

namespace App\Services\Sources;

use App\Models\JobPositionSource;
use App\Services\AbstractJobPositionSource;
use Illuminate\Support\Facades\Http;

class TelegramJobPositionSource extends AbstractJobPositionSource
{
    private const API_URL = 'https://api.telegram.org/bot';

    public function sync(JobPositionSource $source): void
    {
        $response = Http::get(self::API_URL . $source->credentials['bot_token'] . '/getUpdates', [
            'chat_id' => $source->credentials['chat_id'],
            'offset' => -100, // Get last 100 messages
        ]);

        if (! $response->successful()) {
            throw new \Exception('Failed to fetch data from Telegram: ' . $response->body());
        }

        $messages = collect($response->json()['result'] ?? [])
            ->filter(fn ($update) => isset($update['message']['text']))
            ->map(fn ($update) => $update['message'])
            ->filter(fn ($message) => $this->isJobPost($message['text']));

        foreach ($messages as $message) {
            $jobData = $this->parseJobPost($message['text']);

            if ($jobData) {
                $this->createOrUpdateJobPosition($jobData);
            }
        }

        $this->updateLastSynced($source);
    }

    public function validateCredentials(array $credentials): bool
    {
        if (! isset($credentials['bot_token'], $credentials['chat_id'])) {
            return false;
        }

        try {
            $response = Http::get(self::API_URL . $credentials['bot_token'] . '/getChat', [
                'chat_id' => $credentials['chat_id'],
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    private function isJobPost(string $text): bool
    {
        $keywords = ['job', 'position', 'hiring', 'opportunity', 'remote', 'onsite', 'hybrid'];
        $lowercaseText = strtolower($text);

        return collect($keywords)->some(fn ($keyword) => str_contains($lowercaseText, $keyword));
    }

    private function parseJobPost(string $text): ?array
    {
        // Basic parsing - you might want to enhance this with AI or more sophisticated parsing
        $lines = explode("\n", $text);
        $data = [
            'title' => '',
            'company_name' => '',
            'description' => $text,
            'type' => 'full_time',
        ];

        foreach ($lines as $line) {
            $line = trim($line);
            $lowercaseLine = strtolower($line);

            // Try to identify the job title (usually in the first few lines)
            if (empty($data['title']) && str_contains($lowercaseLine, ['position:', 'role:', 'job:'])) {
                $data['title'] = trim(explode(':', $line, 2)[1] ?? '');

                continue;
            }

            // Try to identify the company
            if (empty($data['company_name']) && str_contains($lowercaseLine, ['company:', 'at:', 'organization:'])) {
                $data['company_name'] = trim(explode(':', $line, 2)[1] ?? '');

                continue;
            }

            // Try to identify the job type
            if (str_contains($lowercaseLine, 'remote')) {
                $data['location'] = 'Remote';
            } elseif (str_contains($lowercaseLine, 'hybrid')) {
                $data['location'] = 'Hybrid';
            }

            // Try to identify salary range
            if (preg_match('/\$(\d+)k?\s*-\s*\$?(\d+)k?/i', $line, $matches)) {
                $data['salary_min'] = (int) $matches[1] * 1000;
                $data['salary_max'] = (int) $matches[2] * 1000;
            }
        }

        // If we couldn't find a title, use the first line
        if (empty($data['title'])) {
            $data['title'] = trim($lines[0]);
        }

        return ! empty($data['title']) ? $data : null;
    }
}

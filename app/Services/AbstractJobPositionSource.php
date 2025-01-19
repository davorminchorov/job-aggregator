<?php

namespace App\Services;

use App\JobPositionSourceInterface;
use App\Models\Company;
use App\Models\JobPosition;
use App\Models\JobPositionSource;
use Illuminate\Support\Str;

abstract class AbstractJobPositionSource implements JobPositionSourceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Create or update a job position
     */
    protected function createOrUpdateJobPosition(array $data, ?Company $company = null): JobPosition
    {
        // Create or update company if provided
        if ($company === null && isset($data['company_name'])) {
            $company = Company::firstOrCreate(
                ['name' => $data['company_name']],
                [
                    'website' => $data['company_website'] ?? null,
                    'location' => $data['company_location'] ?? null,
                ]
            );
        }

        // Create job position if it doesn't exist
        return JobPosition::firstOrCreate(
            [
                'title' => $data['title'],
                'company_id' => $company?->id,
            ],
            [
                'slug' => Str::slug($data['title'] . '-' . ($company?->name ?? 'unknown') . '-' . Str::random(6)),
                'description' => $data['description'] ?? '',
                'requirements' => $data['requirements'] ?? '',
                'benefits' => $data['benefits'] ?? '',
                'location' => $data['location'] ?? '',
                'salary_min' => $data['salary_min'] ?? null,
                'salary_max' => $data['salary_max'] ?? null,
                'type' => $data['type'] ?? 'full_time',
            ]
        );
    }

    /**
     * Update the last synced timestamp
     */
    protected function updateLastSynced(JobPositionSource $source): void
    {
        $source->update(['last_synced_at' => now()]);
    }
}

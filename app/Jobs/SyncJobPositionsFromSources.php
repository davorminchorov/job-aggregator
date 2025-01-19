<?php

namespace App\Jobs;

use App\Models\JobPositionSource;
use App\Services\JobPositionSourceFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncJobPositionsFromSources implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue = 'job-positions';

    public $tries = 3;

    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(JobPositionSourceFactory $factory): void
    {
        $sources = JobPositionSource::with('sourceType')
            ->where('is_active', true)
            ->get();

        foreach ($sources as $source) {
            try {
                $sourceService = $factory->make($source);
                $sourceService->sync($source);

                Log::info("Successfully synced job positions from source: {$source->name}");
            } catch (\Exception $e) {
                Log::error("Failed to sync job positions from source: {$source->name}", [
                    'error' => $e->getMessage(),
                    'source_id' => $source->id,
                    'source_type' => $source->sourceType->key,
                ]);
            }
        }
    }
}

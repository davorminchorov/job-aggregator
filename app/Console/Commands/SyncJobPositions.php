<?php

namespace App\Console\Commands;

use App\Jobs\SyncJobPositionsFromSources;
use Illuminate\Console\Command;

class SyncJobPositions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-job-positions {--source-id= : The ID of a specific source to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync job positions from all active sources or a specific source';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($sourceId = $this->option('source-id')) {
            $source = \App\Models\JobPositionSource::find($sourceId);

            if (!$source) {
                $this->error("Source with ID {$sourceId} not found.");
                return Command::FAILURE;
            }

            if (!$source->is_active) {
                $this->error("Source with ID {$sourceId} is not active.");
                return Command::FAILURE;
            }

            try {
                $factory = app(\App\Services\JobPositionSourceFactory::class);
                $sourceService = $factory->make($source);
                $sourceService->sync($source);

                $this->info("Successfully synced job positions from source: {$source->name}");
                return Command::SUCCESS;
            } catch (\Exception $e) {
                $this->error("Failed to sync job positions from source: {$source->name}");
                $this->error($e->getMessage());
                return Command::FAILURE;
            }
        }

        // Sync all sources using the job
        SyncJobPositionsFromSources::dispatch();
        $this->info('Job dispatched to sync all active sources.');

        return Command::SUCCESS;
    }
}

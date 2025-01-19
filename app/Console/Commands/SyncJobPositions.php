<?php

namespace App\Console\Commands;

use App\Jobs\SyncJobPositionsFromSources;
use App\Models\JobPositionSource;
use App\Services\JobPositionSourceFactory;
use Illuminate\Console\Command;

class SyncJobPositions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-job-positions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync job positions from sources';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $sources = JobPositionSource::with('sourceType')
            ->where('is_active', true)
            ->get();

        if ($sources->isEmpty()) {
            $this->error('No active job position sources found.');
            return self::FAILURE;
        }

        $choices = $sources->pluck('name', 'id')
            ->put('all', 'All Sources')
            ->all();

        $choice = $this->choice(
            'Which source would you like to sync?',
            $choices,
            'all'
        );

        if ($choice === 'all') {
            if ($this->confirm('Are you sure you want to sync all sources?', true)) {
                $this->info('Dispatching job to sync all sources...');
                SyncJobPositionsFromSources::dispatch();
                return self::SUCCESS;
            }

            $this->info('Operation cancelled.');
            return self::SUCCESS;
        }

        $source = $sources->firstWhere('id', $choice);

        if ($this->confirm("Are you sure you want to sync source '{$source->name}'?", true)) {
            $this->info("Syncing source '{$source->name}'...");

            try {
                $factory = app(JobPositionSourceFactory::class);
                $sourceService = $factory->make($source);
                $sourceService->sync($source);

                $this->info("Successfully synced job positions from source: {$source->name}");
                return self::SUCCESS;
            } catch (\Exception $e) {
                $this->error("Failed to sync job positions from source: {$source->name}");
                $this->error($e->getMessage());
                return self::FAILURE;
            }
        }

        $this->info('Operation cancelled.');
        return self::SUCCESS;
    }
}

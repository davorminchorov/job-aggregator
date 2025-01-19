<?php

namespace App\Console;

use App\Jobs\SyncJobPositionsFromSources;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new SyncJobPositionsFromSources)
            ->dailyAt('00:00')
            ->name('sync-job-positions')
            ->withoutOverlapping()
            ->onFailure(function () {
                \Log::error('Failed to sync job positions from sources');
            });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

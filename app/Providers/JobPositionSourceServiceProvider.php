<?php

namespace App\Providers;

use App\Services\JobPositionSourceFactory;
use Illuminate\Support\ServiceProvider;

class JobPositionSourceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(JobPositionSourceFactory::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $factory = $this->app->make(JobPositionSourceFactory::class);

        // Register your sources here
    }
}

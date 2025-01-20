<?php

namespace App\Providers;

use App\Enums\RoleName;
use Illuminate\Support\Facades\Gate;
use Laravel\Pulse\PulseServiceProvider;

class PulseServiceProvider extends PulseServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Register the Pulse gate.
     *
     * This gate determines who can access Pulse in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewPulse', function ($user) {
            return $user->hasRole(RoleName::ADMIN->value);
        });
    }
}

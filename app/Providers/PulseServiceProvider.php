<?php

namespace App\Providers;

use App\Enums\RoleName;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class PulseServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('viewPulse', function ($user) {
            return $user->hasRole(RoleName::ADMIN->value);
        });
    }
}

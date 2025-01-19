<?php

namespace App\Providers;

use App\Enums\RoleName;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('viewHorizon', function ($user) {
            return $user->hasRole(RoleName::ADMIN->value);
        });

        Gate::define('viewPulse', function ($user) {
            return $user->hasRole(RoleName::ADMIN->value);
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Mall;
use App\Policies\MallPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Mall::class => MallPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // If you want admins to be able to do everything, use a before hook.
        // Returning true grants the ability; returning null falls through to normal checks.
        Gate::before(function (?User $user, $ability) {
            return $user && $user->hasRole('admin') ? true : null;
        });

        // Keep explicit gates for clarity and for non-admin checks elsewhere.
        Gate::define('manage-users', fn (?User $user) => $user && $user->hasRole('admin'));
        Gate::define('dashboard', fn (?User $user) => $user && $user->hasRole('admin'));
        Gate::define('manage-roles', fn (?User $user) => $user && $user->hasRole('admin'));
        Gate::define('manage-malls', fn (?User $user) => $user && $user->hasRole('admin'));
        Gate::define('view-audits', fn (?User $user) => $user && $user->hasRole('admin'));
    }
}
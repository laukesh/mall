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

        // Grant all abilities to any super/admin role variants to ensure a "Super Admin" gets full access.
        Gate::before(function (?User $user, $ability) {
            if (! $user) {
                return null;
            }

            // Roles that should be treated as full super-admins.
            $superRoles = ['admin', 'super-admin', 'superadmin', 'super'];

            if ($user->hasAnyRole($superRoles)) {
                return true;
            }

            return null;
        });

        // Explicit gates (kept for clarity and non-admin checks)
        Gate::define('manage-users', fn (?User $user) => $user && $user->hasAnyRole(['admin','super-admin','superadmin']));
        Gate::define('dashboard', fn (?User $user) => $user && $user->hasAnyRole(['admin','super-admin','superadmin']));
        Gate::define('manage-roles', fn (?User $user) => $user && $user->hasAnyRole(['admin','super-admin','superadmin']));
        Gate::define('manage-malls', fn (?User $user) => $user && $user->hasAnyRole(['admin','super-admin','superadmin']));
        Gate::define('view-audits', fn (?User $user) => $user && $user->hasAnyRole(['admin','super-admin','superadmin']));
    }
}

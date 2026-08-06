<?php

namespace App\Providers;

use App\Models\Mall;
use App\Models\User;
use App\Policies\MallPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register the application's policies.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Mall::class => MallPolicy::class,
    ];

    /**
     * Bootstrap any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {

            // Allow every action for Super Admin
            if ($user->is_super_admin == 1) {
                return true;
            }

            return null;
        });

        Gate::define('manage-users', fn($user) => $user->can('manage-users'));

        Gate::define('manage-roles', fn($user) => $user->can('manage-roles'));

        Gate::define('manage-malls', fn($user) => $user->can('manage-malls'));

        Gate::define('view-audits', fn($user) => $user->can('view-audits'));
    }
}
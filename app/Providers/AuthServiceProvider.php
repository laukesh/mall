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
     * The policy mappings for the application.
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
dd($user);
        /*
        |--------------------------------------------------------------------------
        | Super Admin Bypass
        |--------------------------------------------------------------------------
        |
        | A user with the "Super Admin" role or is_super_admin = 1
        | has access to every Gate and Policy automatically.
        |
        */

        Gate::before(function (User $user, string $ability) {
//dd($user);
            if (
                $user->is_super_admin ||
                $user->hasRole('Super Admin')
            ) {
                return true;
            }

            return null;
        });

        /*
        |--------------------------------------------------------------------------
        | Optional Gates
        |--------------------------------------------------------------------------
        | Use these only if your routes use middleware('can:...')
        | Otherwise, if you're using Spatie's permission middleware
        | (permission:users.view), these Gate definitions are not required.
        |--------------------------------------------------------------------------
        */

        Gate::define('dashboard.view', fn(User $user) => $user->can('dashboard.view'));

        Gate::define('users.view', fn(User $user) => $user->can('users.view'));
        Gate::define('users.create', fn(User $user) => $user->can('users.create'));
        Gate::define('users.edit', fn(User $user) => $user->can('users.edit'));
        Gate::define('users.delete', fn(User $user) => $user->can('users.delete'));

        Gate::define('roles.view', fn(User $user) => $user->can('roles.view'));
        Gate::define('roles.create', fn(User $user) => $user->can('roles.create'));
        Gate::define('roles.edit', fn(User $user) => $user->can('roles.edit'));
        Gate::define('roles.delete', fn(User $user) => $user->can('roles.delete'));

        Gate::define('malls.view', fn(User $user) => $user->can('malls.view'));
        Gate::define('malls.create', fn(User $user) => $user->can('malls.create'));
        Gate::define('malls.edit', fn(User $user) => $user->can('malls.edit'));
        Gate::define('malls.delete', fn(User $user) => $user->can('malls.delete'));
        
        Gate::define('buildings.view', fn(User $user) => $user->can('buildings.view'));
        Gate::define('buildings.create', fn(User $user) => $user->can('buildings.create'));
        Gate::define('buildings.edit', fn(User $user) => $user->can('buildings.edit'));
        Gate::define('buildings.delete', fn(User $user) => $user->can('buildings.delete'));

        Gate::define('audit.view', fn(User $user) => $user->can('audit.view'));
    }
}
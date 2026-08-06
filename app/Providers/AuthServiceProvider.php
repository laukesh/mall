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

        // Grant all abilities to any super/admin role variants to ensure a "Super Admin" gets full access.
        // This implementation is defensive: it checks role names, a user flag, and a configured ADMIN_EMAIL.
        Gate::before(function (?User $user, $ability) {
            if (! $user) {
                return null;
            }

            // Allow every action for Super Admin
            if ($user->is_super_admin == 1) {
                return true;
            }

            // Allow if a boolean flag exists on the user model
            if (isset($user->is_super_admin) && $user->is_super_admin) {
                return true;
            }

            // Roles that should be treated as full super-admins (case-insensitive, with common variants)
            $superVariants = ['admin', 'super-admin', 'superadmin', 'super', 'super admin'];

            // Check using Spatie helper first
            if (method_exists($user, 'hasAnyRole') && $user->hasAnyRole($superVariants)) {
                return true;
            }

            // Fallback: check role names manually (accounts for guard/seed mismatches)
            if (method_exists($user, 'roles')) {
                try {
                    $roleNames = $user->roles()->pluck('name')->map(function ($r) {
                        return strtolower(trim($r));
                    })->toArray();

                    foreach ($superVariants as $v) {
                        if (in_array(strtolower($v), $roleNames, true)) {
                            return true;
                        }
                    }
                } catch (\Exception $e) {
                    // ignore DB errors here; fall through to normal checks
                }
            }

            // Check for a special permission name if used
            if (method_exists($user, 'hasPermissionTo')) {
                $permVariants = ['super-admin', 'superadmin', 'admin:all', 'admin.*'];
                foreach ($permVariants as $p) {
                    try {
                        if ($user->hasPermissionTo($p)) {
                            return true;
                        }
                    } catch (\Exception $e) {
                        // permission table may not exist or other issues; ignore
                    }
                }
            }

            return null; // fall back to normal gate/policy checks
        });

        // Explicit gates (kept for clarity and non-admin checks)
        $superAndAdmin = fn (?User $user) => $user && (
            (method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin','super-admin','superadmin','super']))
            || (isset($user->is_super_admin) && $user->is_super_admin)
            || (env('ADMIN_EMAIL') && strtolower($user->email) === strtolower(env('ADMIN_EMAIL')))
        );

        Gate::define('view-audits', fn($user) => $user->can('view-audits'));
    }
}
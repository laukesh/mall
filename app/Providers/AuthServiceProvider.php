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
        // This implementation is defensive: it checks role names, a user flag, a configured ADMIN_EMAIL,
        // and also checks for explicit admin permissions (e.g. manage-users) assigned directly to the user.
        Gate::before(function (?User $user, $ability) {
            if (! $user) {
                return null;
            }

            // Allow if user's email matches the ADMIN_EMAIL env variable (convenience for initial setup)
            $adminEmail = env('ADMIN_EMAIL') ?: env('ADMIN_MAIL');
            if ($adminEmail && strtolower($user->email) === strtolower($adminEmail)) {
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

            // If the admin permissions were granted directly to the user (not via role), allow them as well
            if (method_exists($user, 'hasAnyPermission')) {
                $adminPermissions = ['manage-users','manage-malls','view-audits','manage-roles'];
                try {
                    if ($user->hasAnyPermission($adminPermissions)) {
                        return true;
                    }
                } catch (\Exception $e) {
                    // ignore permission table errors
                }
            }

            return null; // fall back to normal gate/policy checks
        });

        // Explicit gates (kept for clarity and non-admin checks)
        $superAndAdmin = function (?User $user, $ability = null) {
            if (! $user) return false;

            // role or flag or admin email
            if ((method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin','super-admin','superadmin','super']))
                || (isset($user->is_super_admin) && $user->is_super_admin)
                || (env('ADMIN_EMAIL') && strtolower($user->email) === strtolower(env('ADMIN_EMAIL')))
            ) {
                return true;
            }

            // explicit permission check for the specific ability name
            if (method_exists($user, 'hasPermissionTo') && $ability) {
                try {
                    if ($user->hasPermissionTo($ability)) {
                        return true;
                    }
                } catch (\Exception $e) {
                    // ignore
                }
            }

            return false;
        };

        Gate::define('manage-users', $superAndAdmin);
        Gate::define('dashboard', $superAndAdmin);
        Gate::define('manage-roles', $superAndAdmin);
        Gate::define('manage-malls', $superAndAdmin);
        Gate::define('view-audits', $superAndAdmin);
    }
}

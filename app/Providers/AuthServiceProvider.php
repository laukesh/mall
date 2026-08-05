<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
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

        // Additional gates
        Gate::define('manage-users', function ($user) {
            return $user->hasRole('admin');
        });
    }
}

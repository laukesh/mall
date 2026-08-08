<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Repository Bindings
        |--------------------------------------------------------------------------
        | Use safe binding helpers so we don't attempt to bind interfaces or
        | implementations that don't exist (this prevents "not instantiable"
        | errors when namespaces differ).
        */

        // Mall repository (explicit)
        $this->safeBind(
            \App\Repositories\MallRepositoryInterface::class,
            \App\Repositories\EloquentMallRepository::class
        );

        // Building repository (support multiple common interface namespaces)
        $this->safeBindCandidates([
            // interface => implementation
            \App\Repositories\BuildingRepositoryInterface::class => \App\Repositories\EloquentBuildingRepository::class,
            \App\Repositories\Interfaces\BuildingRepositoryInterface::class => \App\Repositories\EloquentBuildingRepository::class,
            // If your implementation lives in a sub-namespace, add here:
            \App\Repositories\Interfaces\BuildingRepositoryInterface::class => \App\Repositories\Eloquent\BuildingRepository::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in Production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Register user observer
        User::observe(UserObserver::class);
    }

    /**
     * Bind interface to implementation only when both exist.
     */
    protected function safeBind(string $interface, string $implementation): void
    {
        if (interface_exists($interface) && class_exists($implementation)) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Attempt multiple candidate bindings. Stops after the first successful bind.
     *
     * Accepts an associative array of interface => implementation pairs.
     */
    protected function safeBindCandidates(array $candidates): void
    {
        foreach ($candidates as $interface => $implementation) {
            if (interface_exists($interface) && class_exists($implementation)) {
                $this->app->bind($interface, $implementation);
                // stop after the first valid binding for a given interface
                // (if the same interface key repeats, the first that passes will be used)
                break;
            }
        }
    }
}
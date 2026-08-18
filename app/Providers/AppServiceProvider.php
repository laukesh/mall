<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\BuildingRepositoryInterface;
use App\Repositories\EloquentBuildingRepository;
use App\Repositories\EloquentMallRepository;
use App\Repositories\MallRepositoryInterface;
use App\Repositories\FloorRepositoryInterface;
use App\Repositories\EloquentFloorRepository;
use App\Repositories\ZoneRepositoryInterface;
use App\Repositories\EloquentZoneRepository;
use App\Repositories\InvoiceRepositoryInterface;
use App\Repositories\EloquentInvoiceRepository;
use App\Repositories\InvoiceItemRepositoryInterface;
use App\Repositories\EloquentInvoiceItemRepository;
use App\Repositories\DepartmentRepositoryInterface;
use App\Repositories\EloquentDepartmentRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     */
    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Mall Repository
        |--------------------------------------------------------------------------
        */
        $this->app->bind(
            MallRepositoryInterface::class,
            EloquentMallRepository::class
        );

        /*
        |--------------------------------------------------------------------------
        | Building Repository
        |--------------------------------------------------------------------------
        */
        $this->app->bind(
            BuildingRepositoryInterface::class,
            EloquentBuildingRepository::class
        );
         /*
        |--------------------------------------------------------------------------
        | Building floor Repository
        |--------------------------------------------------------------------------
        */
        $this->app->bind(
            FloorRepositoryInterface::class,
            EloquentFloorRepository::class
        );
           /*
        |--------------------------------------------------------------------------
        | Building zone Repository
        |--------------------------------------------------------------------------
        */
        $this->app->bind(
            ZoneRepositoryInterface::class,
            EloquentZoneRepository::class
        );
             /*
        |--------------------------------------------------------------------------
        | Building unit type Repository
        |--------------------------------------------------------------------------
        */
        $this->app->bind(
            \App\Repositories\UnitTypeRepositoryInterface::class,
            \App\Repositories\EloquentUnitTypeRepository::class
        );
           $this->app->bind(
            InvoiceRepositoryInterface::class,
            EloquentInvoiceRepository::class
        );

        $this->app->bind(
            InvoiceItemRepositoryInterface::class,
            EloquentInvoiceItemRepository::class
        );
        $this->app->bind(\App\Repositories\ComplaintRepositoryInterface::class, \App\Repositories\EloquentComplaintRepository::class);
        $this->app->bind(\App\Repositories\MaintenanceHistoryRepositoryInterface::class, \App\Repositories\EloquentMaintenanceHistoryRepository::class);
        $this->app->bind(\App\Repositories\MaintenanceRequestRepositoryInterface::class, \App\Repositories\EloquentMaintenanceRequestRepository::class);
        $this->app->bind(\App\Repositories\PreventiveMaintenanceRepositoryInterface::class, \App\Repositories\EloquentPreventiveMaintenanceRepository::class);
        $this->app->bind(\App\Repositories\VendorContractRepositoryInterface::class, \App\Repositories\EloquentVendorContractRepository::class);
        $this->app->bind(\App\Repositories\VendorPaymentRepositoryInterface::class, \App\Repositories\EloquentVendorPaymentRepository::class);
        $this->app->bind(\App\Repositories\VendorPerformanceRepositoryInterface::class, \App\Repositories\EloquentVendorPerformanceRepository::class);
        $this->app->bind(\App\Repositories\VendorServiceRepositoryInterface::class, \App\Repositories\EloquentVendorServiceRepository::class);
        $this->app->bind(\App\Repositories\WorkOrderRepositoryInterface::class, \App\Repositories\EloquentWorkOrderRepository::class);
        $this->app->bind(\App\Repositories\WorkOrderTaskRepositoryInterface::class, \App\Repositories\EloquentWorkOrderTaskRepository::class);
        $this->app->bind(\App\Repositories\AssetRepositoryInterface::class, \App\Repositories\EloquentAssetRepository::class);
        $this->app->bind(\App\Repositories\DepartmentRepositoryInterface::class, \App\Repositories\EloquentDepartmentRepository::class);
         $this->app->bind(\App\Repositories\UnitDocumentRepositoryInterface::class, \App\Repositories\EloquentUnitDocumentRepository::class);
   
        $this->app->bind(\App\Repositories\AssetCategoryRepositoryInterface::class, \App\Repositories\EloquentAssetCategoryRepository::class);
   }

    /**
     * Bootstrap application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Force HTTPS in Production
        |--------------------------------------------------------------------------
        */
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        /*
        |--------------------------------------------------------------------------
        | User Observer
        |--------------------------------------------------------------------------
        */
        User::observe(UserObserver::class);
    }
}
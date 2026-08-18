<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\Assets\MallController;
use App\Http\Controllers\Admin\Assets\BuildingController;
use App\Http\Controllers\Admin\Assets\FloorController;
use App\Http\Controllers\Admin\Assets\ZoneController;
use App\Http\Controllers\Admin\Assets\UnitTypeController;
use App\Http\Controllers\Admin\Assets\AssetController;
use App\Http\Controllers\Admin\Assets\AssetCategoryController;
use App\Http\Controllers\Admin\Assets\UnitController;
use App\Http\Controllers\Admin\Assets\UnitStatusController;
use App\Http\Controllers\Admin\Assets\UnitDocumentController;
use App\Http\Controllers\Admin\Assets\DepartmentController;

use App\Http\Controllers\Admin\Leasing\LeasingController;
use App\Http\Controllers\Admin\Leasing\LeaseProposalController;
use App\Http\Controllers\Admin\Leasing\LeaseAgreementController;
use App\Http\Controllers\Admin\Leasing\LeaseTermController;
use App\Http\Controllers\Admin\Leasing\LeaseDocumentController;
use App\Http\Controllers\Admin\Leasing\LeaseRenewalController;
use App\Http\Controllers\Admin\Leasing\LeaseEscalationController;
use App\Http\Controllers\Admin\Leasing\LeaseHistoryController;
use App\Http\Controllers\Admin\Leasing\LeaseTerminationController;
use App\Http\Controllers\Admin\Leasing\LeaseDashboardController;

use App\Http\Controllers\Admin\Tenant\TenantDashboardController;
use App\Http\Controllers\Admin\Tenant\TenantController;
use App\Http\Controllers\Admin\Tenant\TenantContactController;
use App\Http\Controllers\Admin\Tenant\TenantAddressController;
use App\Http\Controllers\Admin\Tenant\TenantBankAccountController;
use App\Http\Controllers\Admin\Tenant\TenantDocumentController;
use App\Http\Controllers\Admin\Tenant\TenantEmergencyContactController;
use App\Http\Controllers\Admin\Tenant\TenantNoteController;
use App\Http\Controllers\Admin\Tenant\TenantHistoryController;

use App\Http\Controllers\Admin\Revenue\TaxConfigurationController;
use App\Http\Controllers\Admin\Revenue\DepositController;
use App\Http\Controllers\Admin\Revenue\DepositReceiptController;
use App\Http\Controllers\Admin\Revenue\DepositRefundController;
use App\Http\Controllers\Admin\Revenue\RentScheduleController;
use App\Http\Controllers\Admin\Revenue\InvoiceController;
use App\Http\Controllers\Admin\Revenue\RentPaymentController;
use App\Http\Controllers\Admin\Revenue\RevenueDashboardController;
use App\Http\Controllers\Admin\Revenue\OutstandingController;
use App\Http\Controllers\Admin\Revenue\RevenueReportController;
use App\Http\Controllers\Admin\Revenue\ChargeTypeController;
use App\Http\Controllers\Admin\Revenue\ReconciliationController;
use App\Http\Controllers\Admin\Revenue\RevenueAuditLogController;

use App\Http\Controllers\Admin\Fitout\FitoutRequestController;
use App\Http\Controllers\Admin\Fitout\ContractorController;
use App\Http\Controllers\Admin\Fitout\FitoutStageController;
use App\Http\Controllers\Admin\Fitout\FitoutDocumentController;
use App\Http\Controllers\Admin\Fitout\FitoutApprovalController;
use App\Http\Controllers\Admin\Fitout\FitoutInspectionController;
use App\Http\Controllers\Admin\Fitout\SnagListController;
use App\Http\Controllers\Admin\Fitout\HandoverController;
use App\Http\Controllers\Admin\Fitout\FitoutDashboardController;

use App\Http\Controllers\Admin\Complaints\ComplaintController;
use App\Http\Controllers\Admin\Maintenance\MaintenanceHistoryController;
use App\Http\Controllers\Admin\Maintenance\MaintenanceRequestController;
use App\Http\Controllers\Admin\Maintenance\PreventiveMaintenanceController;
use App\Http\Controllers\Admin\Vendors\VendorContractController;
use App\Http\Controllers\Admin\Vendors\VendorPaymentController;
use App\Http\Controllers\Admin\Vendors\VendorPerformanceController;
use App\Http\Controllers\Admin\Vendors\VendorServiceController;
use App\Http\Controllers\Admin\Maintenance\WorkOrderController;
use App\Http\Controllers\Admin\Maintenance\WorkOrderTaskController;
//Sudhir
//use App\Http\Controllers\DashboardController;
//use App\Http\Controllers\UserController;
//use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WorkPackageController;
//use App\Http\Controllers\ContractorController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MobilizationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HseController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LandAcquisitionController;
use App\Http\Controllers\FeasibilityController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\CommonController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)->group(function () {

    Route::get('/login', 'showLoginForm')->name('login.form');

    Route::post('/login', 'login')
        ->middleware('throttle:10,1')
        ->name('login');

    Route::get('/register', 'showRegisterForm')->name('register.form');

    Route::post('/register', 'register')->name('register');

    Route::get('/forgot-password', 'showForgotForm')->name('forgot.form');

    Route::post('/forgot-password', 'forgotPassword')
        ->middleware('throttle:5,1')
        ->name('password.email');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});

/*
|--------------------------------------------------------------------------
| Debug Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/debug-building', function () {

        $user = auth()->user();

        return [
            'id' => $user->id,
            'name' => $user->name,
            'roles' => $user->getRoleNames(),
            'proposal-units_view' => $user->can('proposal-units.view'),
            'proposal-units_create' => $user->can('proposal-units.create'),
            'proposal-units_edit' => $user->can('proposal-units.edit'),
            'proposal-units_delete' => $user->can('proposal-units.delete'),
            'is_super_admin' => (bool) $user->is_super_admin,
        ];
    });

    Route::get('/debug-role', function () {

        $user = Auth::user();

        dd([
            'User' => $user,
            'Roles' => $user->getRoleNames(),
            'Permissions' => $user->getPermissionNames(),
            'All Permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    });

});

/*
|--------------------------------------------------------------------------
| Authentication / Profile
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    Route::prefix('profile')->name('profile.')->group(function () {

        Route::get('/dashboard', [AuthController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/', [AuthController::class, 'profileForm'])
            ->middleware('permission:profile.view')
            ->name('show');

        Route::post('/update', [AuthController::class, 'updateProfile'])
            ->middleware('permission:profile.update')
            ->name('update');

        Route::post('/change-password', [AuthController::class, 'changePassword'])
            ->middleware('permission:profile.update')
            ->name('change-password');
    });
});

/*
|--------------------------------------------------------------------------
| Authenticated Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        /*
        |----------------------------------------------------------------
        | Dashboard
        |----------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->middleware('permission:dashboard.view')
            ->name('dashboard');

        /*
        |----------------------------------------------------------------
        | User Management
        |----------------------------------------------------------------
        */

        Route::prefix('users')->name('users.')->group(function () {

            Route::get('/', [UserManagementController::class, 'index'])
                ->middleware('permission:users.view')
                ->name('index');

            Route::get('/create', [UserManagementController::class, 'create'])
                ->middleware('permission:users.create')
                ->name('create');

            Route::post('/', [UserManagementController::class, 'store'])
                ->middleware('permission:users.create')
                ->name('store');

            Route::get('/{user}', [UserManagementController::class, 'show'])
                ->middleware('permission:users.view')
                ->name('show');

            Route::get('/{user}/edit', [UserManagementController::class, 'edit'])
                ->middleware('permission:users.edit')
                ->name('edit');

            Route::put('/{user}', [UserManagementController::class, 'update'])
                ->middleware('permission:users.edit')
                ->name('update');

            Route::delete('/{user}', [UserManagementController::class, 'destroy'])
                ->middleware('permission:users.delete')
                ->name('destroy');

            Route::post('/{user}/assign-role', [UserManagementController::class, 'assignRole'])
                ->middleware('permission:users.edit')
                ->name('assign-role');

            Route::post('/{user}/revoke-role', [UserManagementController::class, 'revokeRole'])
                ->middleware('permission:users.edit')
                ->name('revoke-role');

            Route::post('/{user}/activate', [UserManagementController::class, 'activate'])
                ->middleware('permission:users.edit')
                ->name('activate');

            Route::post('/{user}/deactivate', [UserManagementController::class, 'deactivate'])
                ->middleware('permission:users.edit')
                ->name('deactivate');

            Route::get('/{user}/audits', [UserManagementController::class, 'audits'])
                ->middleware('permission:audit.view')
                ->name('audits');
        });

        /*
        |----------------------------------------------------------------
        | Role Management
        |----------------------------------------------------------------
        */

        Route::resource('roles', RoleController::class)->middleware([
            'index'   => 'permission:roles.view',
            'show'    => 'permission:roles.view',
            'create'  => 'permission:roles.create',
            'store'   => 'permission:roles.create',
            'edit'    => 'permission:roles.edit',
            'update'  => 'permission:roles.edit',
            'destroy' => 'permission:roles.delete',
        ]);

        /*
        |----------------------------------------------------------------
        | Assets
        |----------------------------------------------------------------
        */

        Route::prefix('assets')->name('assets.')->group(function () {

            Route::resource('malls', MallController::class)->middleware([
                'index'   => 'permission:malls.view',
                'show'    => 'permission:malls.view',
                'create'  => 'permission:malls.create',
                'store'   => 'permission:malls.create',
                'edit'    => 'permission:malls.edit',
                'update'  => 'permission:malls.edit',
                'destroy' => 'permission:malls.delete',
            ]);

            Route::resource('buildings', BuildingController::class)->middleware([
                'index'   => 'permission:buildings.view',
                'show'    => 'permission:buildings.view',
                'create'  => 'permission:buildings.create',
                'store'   => 'permission:buildings.create',
                'edit'    => 'permission:buildings.edit',
                'update'  => 'permission:buildings.edit',
                'destroy' => 'permission:buildings.delete',
            ]);

            Route::resource('floors', FloorController::class)->middleware([
                'index'   => 'permission:floors.view',
                'show'    => 'permission:floors.view',
                'create'  => 'permission:floors.create',
                'store'   => 'permission:floors.create',
                'edit'    => 'permission:floors.edit',
                'update'  => 'permission:floors.edit',
                'destroy' => 'permission:floors.delete',
            ]);

            Route::resource('zones', ZoneController::class)->middleware([
                'index'   => 'permission:zones.view',
                'show'    => 'permission:zones.view',
                'create'  => 'permission:zones.create',
                'store'   => 'permission:zones.create',
                'edit'    => 'permission:zones.edit',
                'update'  => 'permission:zones.edit',
                'destroy' => 'permission:zones.delete',
            ]);

            Route::resource('unit-types', UnitTypeController::class)
                ->names('unit_types')
                ->middleware([
                    'index'   => 'permission:unit_types.view',
                    'show'    => 'permission:unit_types.view',
                    'create'  => 'permission:unit_types.create',
                    'store'   => 'permission:unit_types.create',
                    'edit'    => 'permission:unit_types.edit',
                    'update'  => 'permission:unit_types.edit',
                    'destroy' => 'permission:unit_types.delete',
                ]);

            Route::resource('units', UnitController::class)->middleware([
                'index'   => 'permission:units.view',
                'show'    => 'permission:units.view',
                'create'  => 'permission:units.create',
                'store'   => 'permission:units.create',
                'edit'    => 'permission:units.edit',
                'update'  => 'permission:units.edit',
                'destroy' => 'permission:units.delete',
            ]);

            Route::resource('unit-statuses', UnitStatusController::class)->middleware([
                'index'   => 'permission:unit_statuses.view',
                'show'    => 'permission:unit_statuses.view',
                'create'  => 'permission:unit_statuses.create',
                'store'   => 'permission:unit_statuses.create',
                'edit'    => 'permission:unit_statuses.edit',
                'update'  => 'permission:unit_statuses.edit',
                'destroy' => 'permission:unit_statuses.delete',
            ]);

            Route::resource('assets', AssetController::class)->middleware([
                'index'   => 'permission:assets.view',
                'show'    => 'permission:assets.view',
                'create'  => 'permission:assets.create',
                'store'   => 'permission:assets.create',
                'edit'    => 'permission:assets.edit',
                'update'  => 'permission:assets.edit',
                'destroy' => 'permission:assets.delete',
            ]);

            Route::resource('asset-categories', AssetCategoryController::class)->middleware([
                'index'   => 'permission:asset_categories.view',
                'show'    => 'permission:asset_categories.view',
                'create'  => 'permission:asset_categories.create',
                'store'   => 'permission:asset_categories.create',
                'edit'    => 'permission:asset_categories.edit',
                'update'  => 'permission:asset_categories.edit',
                'destroy' => 'permission:asset_categories.delete',
            ]);

            Route::resource('unit-documents', UnitDocumentController::class)->middleware([
                'index'   => 'permission:unit_documents.view',
                'show'    => 'permission:unit_documents.view',
                'create'  => 'permission:unit_documents.create',
                'store'   => 'permission:unit_documents.create',
                'edit'    => 'permission:unit_documents.edit',
                'update'  => 'permission:unit_documents.edit',
                'destroy' => 'permission:unit_documents.delete',
            ]);

            Route::resource('departments', DepartmentController::class)->middleware([
                'index'   => 'permission:departments.view',
                'show'    => 'permission:departments.view',
                'create'  => 'permission:departments.create',
                'store'   => 'permission:departments.create',
                'edit'    => 'permission:departments.edit',
                'update'  => 'permission:departments.edit',
                'destroy' => 'permission:departments.delete',
            ]);
        });

        /*
        |----------------------------------------------------------------
        | Maintenance
        |----------------------------------------------------------------
        */

        Route::resource('maintenance-history', MaintenanceHistoryController::class)->middleware([
            'index'   => 'permission:maintenance_history.view',
            'show'    => 'permission:maintenance_history.view',
            'create'  => 'permission:maintenance_history.create',
            'store'   => 'permission:maintenance_history.create',
            'edit'    => 'permission:maintenance_history.edit',
            'update'  => 'permission:maintenance_history.edit',
            'destroy' => 'permission:maintenance_history.delete',
        ]);

        Route::resource('maintenance-requests', MaintenanceRequestController::class)->middleware([
            'index'   => 'permission:maintenance_requests.view',
            'show'    => 'permission:maintenance_requests.view',
            'create'  => 'permission:maintenance_requests.create',
            'store'   => 'permission:maintenance_requests.create',
            'edit'    => 'permission:maintenance_requests.edit',
            'update'  => 'permission:maintenance_requests.edit',
            'destroy' => 'permission:maintenance_requests.delete',
        ]);

        Route::resource('preventive-maintenance', PreventiveMaintenanceController::class)->middleware([
            'index'   => 'permission:preventive_maintenance.view',
            'show'    => 'permission:preventive_maintenance.view',
            'create'  => 'permission:preventive_maintenance.create',
            'store'   => 'permission:preventive_maintenance.create',
            'edit'    => 'permission:preventive_maintenance.edit',
            'update'  => 'permission:preventive_maintenance.edit',
            'destroy' => 'permission:preventive_maintenance.delete',
        ]);

        Route::prefix('maintenance')->name('maintenance.')->group(function () {

            Route::resource('complaints', ComplaintController::class)->middleware([
                'index'   => 'permission:complaints.view',
                'show'    => 'permission:complaints.view',
                'create'  => 'permission:complaints.create',
                'store'   => 'permission:complaints.create',
                'edit'    => 'permission:complaints.edit',
                'update'  => 'permission:complaints.edit',
                'destroy' => 'permission:complaints.delete',
            ]);

            Route::resource('vendor-contracts', VendorContractController::class)->middleware([
                'index'   => 'permission:vendor_contracts.view',
                'show'    => 'permission:vendor_contracts.view',
                'create'  => 'permission:vendor_contracts.create',
                'store'   => 'permission:vendor_contracts.create',
                'edit'    => 'permission:vendor_contracts.edit',
                'update'  => 'permission:vendor_contracts.edit',
                'destroy' => 'permission:vendor_contracts.delete',
            ]);

            Route::resource('vendor-payments', VendorPaymentController::class)->middleware([
                'index'   => 'permission:vendor_payments.view',
                'show'    => 'permission:vendor_payments.view',
                'create'  => 'permission:vendor_payments.create',
                'store'   => 'permission:vendor_payments.create',
                'edit'    => 'permission:vendor_payments.edit',
                'update'  => 'permission:vendor_payments.edit',
                'destroy' => 'permission:vendor_payments.delete',
            ]);

            Route::resource('vendor-performance', VendorPerformanceController::class)->middleware([
                'index'   => 'permission:vendor_performance.view',
                'show'    => 'permission:vendor_performance.view',
                'create'  => 'permission:vendor_performance.create',
                'store'   => 'permission:vendor_performance.create',
                'edit'    => 'permission:vendor_performance.edit',
                'update'  => 'permission:vendor_performance.edit',
                'destroy' => 'permission:vendor_performance.delete',
            ]);

            Route::resource('vendor-services', VendorServiceController::class)->middleware([
                'index'   => 'permission:vendor_services.view',
                'show'    => 'permission:vendor_services.view',
                'create'  => 'permission:vendor_services.create',
                'store'   => 'permission:vendor_services.create',
                'edit'    => 'permission:vendor_services.edit',
                'update'  => 'permission:vendor_services.edit',
                'destroy' => 'permission:vendor_services.delete',
            ]);

            Route::resource('work-orders', WorkOrderController::class)->middleware([
                'index'   => 'permission:work_orders.view',
                'show'    => 'permission:work_orders.view',
                'create'  => 'permission:work_orders.create',
                'store'   => 'permission:work_orders.create',
                'edit'    => 'permission:work_orders.edit',
                'update'  => 'permission:work_orders.edit',
                'destroy' => 'permission:work_orders.delete',
            ]);

            Route::resource('work-order-tasks', WorkOrderTaskController::class)->middleware([
                'index'   => 'permission:work_order_tasks.view',
                'show'    => 'permission:work_order_tasks.view',
                'create'  => 'permission:work_order_tasks.create',
                'store'   => 'permission:work_order_tasks.create',
                'edit'    => 'permission:work_order_tasks.edit',
                'update'  => 'permission:work_order_tasks.edit',
                'destroy' => 'permission:work_order_tasks.delete',
            ]);
        });

        /*
        |----------------------------------------------------------------
        | Leasing
        |----------------------------------------------------------------
        */

        Route::prefix('leasing')->name('leasing.')->group(function () {

            Route::resource('proposals', LeaseProposalController::class);

            Route::post('proposals/{id}/submit', [LeaseProposalController::class, 'submit'])
                ->name('proposals.submit');

            Route::post('proposals/{id}/approve', [LeaseProposalController::class, 'approve'])
                ->name('proposals.approve');

            Route::post('proposals/{id}/reject', [LeaseProposalController::class, 'reject'])
                ->name('proposals.reject');

            Route::post('agreements/{id}/activate', [LeaseAgreementController::class, 'activate'])
                ->name('agreements.activate');

            Route::resource('agreements', LeaseAgreementController::class);

            Route::resource('terms', LeaseTermController::class);

            Route::resource('documents', LeaseDocumentController::class);

            Route::post('documents/{document}/verify', [LeaseDocumentController::class, 'verify'])
                ->name('documents.verify');

            Route::post('documents/{document}/reject', [LeaseDocumentController::class, 'reject'])
                ->name('documents.reject');

            Route::get('agreements/{agreement}/renew', [LeaseAgreementController::class, 'renew'])
                ->name('agreements.renew');

            Route::post('agreements/{agreement}/renew', [LeaseAgreementController::class, 'processRenewal'])
                ->name('agreements.process-renewal');

            Route::resource('renewals', LeaseRenewalController::class)->only([
                'index', 'create', 'store', 'show', 'edit', 'update',
            ]);

            Route::post('renewals/{renewal}/submit', [LeaseRenewalController::class, 'submit'])
                ->name('renewals.submit');

            Route::post('renewals/{renewal}/approve', [LeaseRenewalController::class, 'approve'])
                ->name('renewals.approve');

            Route::post('renewals/{renewal}/reject', [LeaseRenewalController::class, 'reject'])
                ->name('renewals.reject');

            Route::post('renewals/{renewal}/cancel', [LeaseRenewalController::class, 'cancel'])
                ->name('renewals.cancel');

            Route::get('renewals/{renewal}/convert', [LeaseRenewalController::class, 'convert'])
                ->name('renewals.convert');

            Route::post('renewals/{renewal}/convert', [LeaseRenewalController::class, 'convertStore'])
                ->name('renewals.convert.store');

            Route::resource('escalations', LeaseEscalationController::class)->only([
                'index', 'create', 'store', 'show',
            ]);

            Route::post('escalations/{escalation}/approve', [LeaseEscalationController::class, 'approve'])
                ->name('escalations.approve');

            Route::post('escalations/{escalation}/cancel', [LeaseEscalationController::class, 'cancel'])
                ->name('escalations.cancel');

            Route::get('history', [LeaseHistoryController::class, 'index'])
                ->name('history.index');

            Route::resource('terminations', LeaseTerminationController::class);

            Route::post('terminations/{id}/submit', [LeaseTerminationController::class, 'submit'])
                ->name('terminations.submit');

            Route::post('terminations/{id}/approve', [LeaseTerminationController::class, 'approve'])
                ->name('terminations.approve');

            Route::post('terminations/{id}/cancel', [LeaseTerminationController::class, 'cancel'])
                ->name('terminations.cancel');

            Route::post('terminations/{id}/complete-inspection', [LeaseTerminationController::class, 'completeInspection'])
                ->name('terminations.completeInspection');

            Route::post('terminations/{id}/complete-handover', [LeaseTerminationController::class, 'completeHandover'])
                ->name('terminations.completeHandover');

            Route::post('terminations/{id}/complete', [LeaseTerminationController::class, 'complete'])
                ->name('terminations.complete');

            Route::get('dashboard', [LeaseDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/', [LeasingController::class, 'index'])->name('index');

            Route::get('/{agreement}', [LeasingController::class, 'show'])->name('show');
        });

        /*
        |----------------------------------------------------------------
        | Tenants
        |----------------------------------------------------------------
        */

        Route::get('tenants/dashboard', [TenantDashboardController::class, 'index'])
            ->name('tenants.dashboard');

        Route::resource('tenants', TenantController::class);

        // Contacts
        Route::get('tenants/{tenant}/contacts', [TenantContactController::class, 'index'])
            ->name('tenants.contacts.index');
        Route::post('tenants/{tenant}/contacts', [TenantContactController::class, 'store'])
            ->name('tenants.contacts.store');
        Route::get('tenants/{tenant}/contacts/{contact}/edit', [TenantContactController::class, 'edit'])
            ->name('tenants.contacts.edit');
        Route::put('tenants/{tenant}/contacts/{contact}', [TenantContactController::class, 'update'])
            ->name('tenants.contacts.update');
        Route::delete('tenants/{tenant}/contacts/{contact}', [TenantContactController::class, 'destroy'])
            ->name('tenants.contacts.destroy');

        // Addresses
        Route::get('tenants/{tenant}/addresses', [TenantAddressController::class, 'index'])
            ->name('tenants.addresses.index');
        Route::post('tenants/{tenant}/addresses', [TenantAddressController::class, 'store'])
            ->name('tenants.addresses.store');
        Route::get('tenants/{tenant}/addresses/{address}/edit', [TenantAddressController::class, 'edit'])
            ->name('tenants.addresses.edit');
        Route::put('tenants/{tenant}/addresses/{address}', [TenantAddressController::class, 'update'])
            ->name('tenants.addresses.update');
        Route::delete('tenants/{tenant}/addresses/{address}', [TenantAddressController::class, 'destroy'])
            ->name('tenants.addresses.destroy');

        // Bank Accounts
        Route::get('tenants/{tenant}/bank-accounts', [TenantBankAccountController::class, 'index'])
            ->name('tenants.bank-accounts.index');
        Route::post('tenants/{tenant}/bank-accounts', [TenantBankAccountController::class, 'store'])
            ->name('tenants.bank-accounts.store');
        Route::get('tenants/{tenant}/bank-accounts/{account}/edit', [TenantBankAccountController::class, 'edit'])
            ->name('tenants.bank-accounts.edit');
        Route::put('tenants/{tenant}/bank-accounts/{account}', [TenantBankAccountController::class, 'update'])
            ->name('tenants.bank-accounts.update');
        Route::delete('tenants/{tenant}/bank-accounts/{account}', [TenantBankAccountController::class, 'destroy'])
            ->name('tenants.bank-accounts.destroy');

        // Documents
        Route::get('tenants/{tenant}/documents', [TenantDocumentController::class, 'index'])
            ->name('tenants.documents.index');
        Route::post('tenants/{tenant}/documents', [TenantDocumentController::class, 'store'])
            ->name('tenants.documents.store');
        Route::get('tenants/{tenant}/documents/{document}/edit', [TenantDocumentController::class, 'edit'])
            ->name('tenants.documents.edit');
        Route::put('tenants/{tenant}/documents/{document}', [TenantDocumentController::class, 'update'])
            ->name('tenants.documents.update');
        Route::delete('tenants/{tenant}/documents/{document}', [TenantDocumentController::class, 'destroy'])
            ->name('tenants.documents.destroy');

        // Emergency Contacts
        Route::get('tenants/{tenant}/emergency-contacts', [TenantEmergencyContactController::class, 'index'])
            ->name('tenants.emergency-contacts.index');
        Route::post('tenants/{tenant}/emergency-contacts', [TenantEmergencyContactController::class, 'store'])
            ->name('tenants.emergency-contacts.store');
        Route::get('tenants/{tenant}/emergency-contacts/{contact}/edit', [TenantEmergencyContactController::class, 'edit'])
            ->name('tenants.emergency-contacts.edit');
        Route::put('tenants/{tenant}/emergency-contacts/{contact}', [TenantEmergencyContactController::class, 'update'])
            ->name('tenants.emergency-contacts.update');
        Route::delete('tenants/{tenant}/emergency-contacts/{contact}', [TenantEmergencyContactController::class, 'destroy'])
            ->name('tenants.emergency-contacts.destroy');

        // Notes
        Route::get('tenants/{tenant}/notes', [TenantNoteController::class, 'index'])
            ->name('tenants.notes.index');
        Route::post('tenants/{tenant}/notes', [TenantNoteController::class, 'store'])
            ->name('tenants.notes.store');
        Route::get('tenants/{tenant}/notes/{note}/edit', [TenantNoteController::class, 'edit'])
            ->name('tenants.notes.edit');
        Route::put('tenants/{tenant}/notes/{note}', [TenantNoteController::class, 'update'])
            ->name('tenants.notes.update');
        Route::delete('tenants/{tenant}/notes/{note}', [TenantNoteController::class, 'destroy'])
            ->name('tenants.notes.destroy');

        // History
        Route::get('tenants/{tenant}/history', [TenantHistoryController::class, 'index'])
            ->name('tenants.history.index');

        /*
        |----------------------------------------------------------------
        | Revenue
        |----------------------------------------------------------------
        */

        Route::prefix('revenue')->name('revenue.')->group(function () {

            // Tax Configurations
            Route::get('tax-configurations', [TaxConfigurationController::class, 'index'])
                ->name('tax-configurations.index');
            Route::post('tax-configurations', [TaxConfigurationController::class, 'store'])
                ->name('tax-configurations.store');
            Route::get('tax-configurations/{id}/edit', [TaxConfigurationController::class, 'edit'])
                ->name('tax-configurations.edit');
            Route::put('tax-configurations/{id}', [TaxConfigurationController::class, 'update'])
                ->name('tax-configurations.update');
            Route::delete('tax-configurations/{id}', [TaxConfigurationController::class, 'destroy'])
                ->name('tax-configurations.destroy');

            // Deposits
            Route::get('deposits', [DepositController::class, 'index'])->name('deposits.index');
            Route::post('deposits', [DepositController::class, 'store'])->name('deposits.store');
            Route::get('deposits/{id}/edit', [DepositController::class, 'edit'])->name('deposits.edit');
            Route::put('deposits/{id}', [DepositController::class, 'update'])->name('deposits.update');
            Route::delete('deposits/{id}', [DepositController::class, 'destroy'])->name('deposits.destroy');

            // Deposit Receipts
            Route::get('deposit-receipts', [DepositReceiptController::class, 'index'])
                ->name('deposit-receipts.index');
            Route::get('deposits/{deposit}/receipts', [DepositReceiptController::class, 'index'])
                ->name('deposits.receipts');
            Route::post('deposit-receipts', [DepositReceiptController::class, 'store'])
                ->name('deposit-receipts.store');
            Route::get('deposit-receipts/{id}/edit', [DepositReceiptController::class, 'edit'])
                ->name('deposit-receipts.edit');
            Route::put('deposit-receipts/{id}', [DepositReceiptController::class, 'update'])
                ->name('deposit-receipts.update');
            Route::delete('deposit-receipts/{id}', [DepositReceiptController::class, 'destroy'])
                ->name('deposit-receipts.destroy');
            Route::post('deposit-receipts/{id}/reverse', [DepositReceiptController::class, 'reverse'])
                ->name('deposit-receipts.reverse');
            Route::post('deposit-receipts/{id}/confirm', [DepositReceiptController::class, 'confirm'])
                ->name('deposit-receipts.confirm');

            // Deposit Refunds
            Route::get('deposit-refunds', [DepositRefundController::class, 'index'])
                ->name('deposit-refunds.index');
            Route::post('deposit-refunds', [DepositRefundController::class, 'store'])
                ->name('deposit-refunds.store');
            Route::post('deposit-refunds/{id}/approve', [DepositRefundController::class, 'approve'])
                ->name('deposit-refunds.approve');
            Route::post('deposit-refunds/{id}/process', [DepositRefundController::class, 'process'])
                ->name('deposit-refunds.process');
            Route::post('deposit-refunds/{id}/cancel', [DepositRefundController::class, 'cancel'])
                ->name('deposit-refunds.cancel');

            // Rent Schedules
            Route::get('/rent-schedules', [RentScheduleController::class, 'index'])
                ->name('rent-schedules.index');
            Route::post('/rent-schedules/generate/{agreementId}', [RentScheduleController::class, 'generate'])
                ->name('rent-schedules.generate');
            Route::post('/rent-schedules/{id}/generate-invoice', [RentScheduleController::class, 'generateInvoice'])
                ->name('rent-schedules.generate-invoice');
            Route::get('/rent-schedules/{id}', [RentScheduleController::class, 'show'])
                ->name('rent-schedules.show');

            // Invoices
            Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
            Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
            Route::get('/invoices/{id}/print', [InvoiceController::class, 'print'])->name('invoices.print');

            // Payments
            Route::get('/invoices/{id}/payment/create', [RentPaymentController::class, 'create'])
                ->name('payments.create');
            Route::post('/invoices/{id}/payment', [RentPaymentController::class, 'store'])
                ->name('payments.store');
            Route::get('/payments', [RentPaymentController::class, 'index'])->name('payments.index');
            Route::get('/payments/{id}', [RentPaymentController::class, 'show'])->name('payments.show');
            Route::post('/payments/{id}/confirm', [RentPaymentController::class, 'confirm'])
                ->name('payments.confirm');
            Route::post('/payments/{id}/reverse', [RentPaymentController::class, 'reverse'])
                ->name('payments.reverse');
            Route::post('/payments/{id}/reconcile', [RentPaymentController::class, 'reconcile'])
                ->name('payments.reconcile');
            Route::get('/payments/{id}/receipt', [RentPaymentController::class, 'receipt'])
                ->name('payments.receipt');

            // Dashboard
            Route::get('/dashboard', [RevenueDashboardController::class, 'index'])->name('dashboard');

            // Outstanding
            Route::get('/outstanding', [OutstandingController::class, 'index'])->name('outstanding.index');
            Route::get('/outstanding/overdue', [OutstandingController::class, 'overdue'])->name('outstanding.overdue');
            Route::get('/outstanding/tenants', [OutstandingController::class, 'tenants'])->name('outstanding.tenants');

            // Reports
            Route::get('/reports/revenue', [RevenueReportController::class, 'index'])->name('reports.revenue');
            Route::get('/reports/collections', [RevenueReportController::class, 'collections'])->name('reports.collections');
            Route::get('/reports/charge-wise', [RevenueReportController::class, 'chargeWise'])->name('reports.charge-wise');
            Route::get('/reports/tenant-wise', [RevenueReportController::class, 'tenantWise'])->name('reports.tenant-wise');
            Route::get('/reports/aging', [RevenueReportController::class, 'aging'])->name('reports.aging');

            // Settings: Charge Types
            Route::prefix('settings/charge-types')->name('settings.charge-types.')->group(function () {
                Route::get('/', [ChargeTypeController::class, 'index'])->name('index');
                Route::get('/create', [ChargeTypeController::class, 'create'])->name('create');
                Route::post('/', [ChargeTypeController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [ChargeTypeController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ChargeTypeController::class, 'update'])->name('update');
                Route::delete('/{id}', [ChargeTypeController::class, 'destroy'])->name('destroy');
            });

            // Reconciliation
            Route::prefix('reconciliation')->name('reconciliation.')->group(function () {
                Route::get('/', [ReconciliationController::class, 'index'])->name('index');
                Route::post('/{id}/reconcile', [ReconciliationController::class, 'reconcile'])->name('reconcile');
            });

            // Audit Log
            Route::get('/audit-log', [RevenueAuditLogController::class, 'index'])->name('audit.index');
        });

        /*
        |----------------------------------------------------------------
        | Fit-Out
        |----------------------------------------------------------------
        */

        Route::prefix('fitout')->name('fitout.')->group(function () {

            Route::get('/dashboard', [FitoutDashboardController::class, 'index'])->name('dashboard');

            // Requests
            Route::get('requests', [FitoutRequestController::class, 'index'])->name('requests.index');
            Route::get('requests/create', [FitoutRequestController::class, 'create'])->name('requests.create');
            Route::post('requests', [FitoutRequestController::class, 'store'])->name('requests.store');
            Route::get('requests/{id}', [FitoutRequestController::class, 'show'])->name('requests.show');
            Route::post('requests/{id}/submit', [FitoutRequestController::class, 'submit'])->name('requests.submit');
            Route::post('requests/{id}/start-review', [FitoutRequestController::class, 'startReview'])->name('requests.startReview');
            Route::post('requests/{id}/approve', [FitoutRequestController::class, 'approve'])->name('requests.approve');
            Route::post('requests/{id}/reject', [FitoutRequestController::class, 'reject'])->name('requests.reject');
            Route::post('requests/{id}/start', [FitoutRequestController::class, 'start'])->name('requests.start');
            Route::post('requests/{id}/complete', [FitoutRequestController::class, 'complete'])->name('requests.complete');
            Route::post('requests/{id}/close', [FitoutRequestController::class, 'close'])->name('requests.close');
            Route::post('/requests/{id}/generate-approval', [FitoutRequestController::class, 'generateApproval'])
                ->name('requests.generate-approval');

            // Contractors
            Route::get('contractors', [ContractorController::class, 'index'])->name('contractors.index');
            Route::get('contractors/create', [ContractorController::class, 'create'])->name('contractors.create');
            Route::post('contractors', [ContractorController::class, 'store'])->name('contractors.store');
            Route::get('contractors/{id}', [ContractorController::class, 'show'])->name('contractors.show');
            Route::get('contractors/{id}/edit', [ContractorController::class, 'edit'])->name('contractors.edit');
            Route::put('contractors/{id}', [ContractorController::class, 'update'])->name('contractors.update');
            Route::post('contractors/{id}/approve', [ContractorController::class, 'approve'])->name('contractors.approve');
            Route::post('contractors/{id}/reject', [ContractorController::class, 'reject'])->name('contractors.reject');
            Route::post('contractors/{id}/suspend', [ContractorController::class, 'suspend'])->name('contractors.suspend');

            // Stages
            Route::get('requests/{fitoutRequestId}/stages', [FitoutStageController::class, 'index'])->name('stages.index');
            Route::get('stages/{id}', [FitoutStageController::class, 'show'])->name('stages.show');
            Route::post('stages/{id}/start', [FitoutStageController::class, 'start'])->name('stages.start');
            Route::post('stages/{id}/progress', [FitoutStageController::class, 'updateProgress'])->name('stages.progress');
            Route::post('stages/{id}/complete', [FitoutStageController::class, 'complete'])->name('stages.complete');
            Route::post('stages/{id}/hold', [FitoutStageController::class, 'hold'])->name('stages.hold');
            Route::post('stages/{id}/resume', [FitoutStageController::class, 'resume'])->name('stages.resume');
            Route::get('stages/{id}/edit', [FitoutStageController::class, 'edit'])->name('stages.edit');
            Route::put('stages/{id}', [FitoutStageController::class, 'update'])->name('stages.update');

            // Documents
            Route::resource('documents', FitoutDocumentController::class)->names('documents');
            Route::get('/documents/{id}/review', [FitoutDocumentController::class, 'review'])->name('documents.review');
            Route::post('/documents/{id}/start-review', [FitoutDocumentController::class, 'startReview'])->name('documents.start-review');
            Route::post('/documents/{id}/approve', [FitoutDocumentController::class, 'approve'])->name('documents.approve');
            Route::post('/documents/{id}/reject', [FitoutDocumentController::class, 'reject'])->name('documents.reject');

            // Approvals
            Route::get('/approvals', [FitoutApprovalController::class, 'index'])->name('approvals.index');
            Route::get('/approvals/pending', [FitoutApprovalController::class, 'pending'])->name('approvals.pending');
            Route::get('/approvals/{id}', [FitoutApprovalController::class, 'show'])->name('approvals.show');
            Route::post('/approvals/generate/{fitoutRequestId}', [FitoutApprovalController::class, 'generate'])->name('approvals.generate');
            Route::post('/approvals/{id}/approve', [FitoutApprovalController::class, 'approve'])->name('approvals.approve');
            Route::post('/approvals/{id}/reject', [FitoutApprovalController::class, 'reject'])->name('approvals.reject');

            // Inspections
            Route::get('/inspections', [FitoutInspectionController::class, 'index'])->name('inspections.index');
            Route::get('/inspections/create', [FitoutInspectionController::class, 'create'])->name('inspections.create');
            Route::post('/inspections', [FitoutInspectionController::class, 'store'])->name('inspections.store');
            Route::get('/inspections/{id}', [FitoutInspectionController::class, 'show'])->name('inspections.show');
            Route::get('/inspections/{id}/edit', [FitoutInspectionController::class, 'edit'])->name('inspections.edit');
            Route::put('/inspections/{id}', [FitoutInspectionController::class, 'update'])->name('inspections.update');
            Route::post('/inspections/{id}/start', [FitoutInspectionController::class, 'start'])->name('inspections.start');
            Route::post('/inspections/{id}/complete', [FitoutInspectionController::class, 'complete'])->name('inspections.complete');
            Route::post('/inspections/{id}/cancel', [FitoutInspectionController::class, 'cancel'])->name('inspections.cancel');
            Route::post('/inspections/{id}/reschedule', [FitoutInspectionController::class, 'reschedule'])->name('inspections.reschedule');
            Route::get('/inspections/{id}/reinspection', [FitoutInspectionController::class, 'createReinspection'])->name('inspections.reinspection.create');
            Route::post('/inspections/{id}/reinspection', [FitoutInspectionController::class, 'storeReinspection'])->name('inspections.reinspection.store');

            // Snags
            Route::resource('snags', SnagListController::class)->names('snags');
            Route::post('snags/{id}/resolve', [SnagListController::class, 'resolve'])->name('snags.resolve');
            Route::post('snags/{id}/verify', [SnagListController::class, 'verify'])->name('snags.verify');
            Route::post('snags/{id}/start-verification', [SnagListController::class, 'startVerification'])->name('snags.start-verification');

            // Handovers
            Route::resource('handovers', HandoverController::class)->names('handovers');
            Route::post('handovers/{handover}/schedule', [HandoverController::class, 'schedule'])->name('handovers.schedule');
            Route::post('handovers/{handover}/start', [HandoverController::class, 'start'])->name('handovers.start');
            Route::post('handovers/{handover}/tenant-accept', [HandoverController::class, 'tenantAccept'])->name('handovers.tenant-accept');
            Route::post('handovers/{handover}/contractor-accept', [HandoverController::class, 'contractorAccept'])->name('handovers.contractor-accept');
            Route::post('handovers/{handover}/approve', [HandoverController::class, 'approve'])->name('handovers.approve');
            Route::post('handovers/{handover}/complete', [HandoverController::class, 'complete'])->name('handovers.complete');
            Route::get('handovers/{handover}/certificate', [HandoverController::class, 'certificate'])->name('handovers.certificate');
        });
          /*
        |----------------------------------------------------------------
        |Sudhir
        |----------------------------------------------------------------
        */
 Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/ajax/getcities', [CommonController::class, 'getCities'])->name('ajax.getcities');



    // Project Management
   // Route::group(['prefix' => 'admin/project', 'as' => 'admin.project.'], function () {
   Route::prefix('project')->name('project.')->group(function () {  
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/store', [ProjectController::class, 'store'])->name('store');
        Route::get('/{id}', [ProjectController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('destroy');
        Route::post('/phase/store', [ProjectController::class, 'storePhase'])->name('phase.store');
        Route::post('/team/store', [ProjectController::class, 'storeTeam'])->name('team.store');
    });

    // Work Package Management
  //  Route::group(['prefix' => 'admin/workpackage', 'as' => 'admin.workpackage.'], function () {
       Route::prefix('workpackage')->name('workpackage.')->group(function () {  
           Route::get('/', [WorkPackageController::class, 'index'])->name('index');
        Route::get('/create', [WorkPackageController::class, 'create'])->name('create');
        Route::post('/store', [WorkPackageController::class, 'store'])->name('store');
        Route::get('/{id}', [WorkPackageController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [WorkPackageController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [WorkPackageController::class, 'update'])->name('update');
        Route::delete('/{id}', [WorkPackageController::class, 'destroy'])->name('destroy');
        Route::post('/task/store', [WorkPackageController::class, 'storeTask'])->name('task.store');
    });

    // Contractor Management
  //  Route::group(['prefix' => 'admin/contractor', 'as' => 'admin.contractor.'], function () {
    Route::prefix('contractor')->name('contractor.')->group(function () {  
        Route::get('/', [ContractorController::class, 'index'])->name('index');
        Route::get('/create', [ContractorController::class, 'create'])->name('create');
        Route::post('/store', [ContractorController::class, 'store'])->name('store');
        Route::get('/{id}', [ContractorController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ContractorController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [ContractorController::class, 'update'])->name('update');
        Route::delete('/{id}', [ContractorController::class, 'destroy'])->name('destroy');
        Route::post('/contract/store', [ContractorController::class, 'storeContract'])->name('contract.store');
        Route::post('/bill/store', [ContractorController::class, 'storeBill'])->name('bill.store');
    });

    // Client Management
   // Route::group(['prefix' => 'admin/client', 'as' => 'admin.client.'], function () {
    Route::prefix('client')->name('client.')->group(function () {  
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::get('/create', [ClientController::class, 'create'])->name('create');
        Route::post('/store', [ClientController::class, 'store'])->name('store');
        Route::get('/{id}', [ClientController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [ClientController::class, 'update'])->name('update');
        Route::delete('/{id}', [ClientController::class, 'destroy'])->name('destroy');
        Route::post('/invoice/store', [ClientController::class, 'storeInvoice'])->name('invoice.store');
    });

    // Procurement Management
  //  Route::group(['prefix' => 'admin/procurement', 'as' => 'admin.procurement.'], function () {
   Route::prefix('procurement')->name('procurement.')->group(function () {  
        Route::get('/vendors', [ProcurementController::class, 'vendors'])->name('vendors');
        Route::get('/vendors/create', [ProcurementController::class, 'createVendor'])->name('vendor.create');
        Route::post('/vendors/store', [ProcurementController::class, 'storeVendor'])->name('vendor.store');
        Route::get('/requisitions', [ProcurementController::class, 'requisitions'])->name('requisitions');
        Route::post('/requisitions/store', [ProcurementController::class, 'storeRequisition'])->name('requisition.store');
        Route::get('/orders', [ProcurementController::class, 'orders'])->name('orders');
        Route::post('/orders/store', [ProcurementController::class, 'storeOrder'])->name('order.store');
        Route::get('/receipts', [ProcurementController::class, 'receipts'])->name('receipts');
    });

    // Inventory Management
  //  Route::group(['prefix' => 'admin/inventory', 'as' => 'admin.inventory.'], function () {
  Route::prefix('inventory')->name('inventory.')->group(function () {  
        Route::get('/materials', [InventoryController::class, 'materials'])->name('materials');
        Route::post('/materials/store', [InventoryController::class, 'storeMaterial'])->name('material.store');
        Route::get('/warehouses', [InventoryController::class, 'warehouses'])->name('warehouses');
        Route::post('/warehouses/store', [InventoryController::class, 'storeWarehouse'])->name('warehouse.store');
        Route::get('/stock', [InventoryController::class, 'stock'])->name('stock');
        Route::post('/stock/store', [InventoryController::class, 'storeStock'])->name('stock.store');
        Route::get('/issue-requests', [InventoryController::class, 'issueRequests'])->name('issue-requests');
        Route::post('/issue-requests/store', [InventoryController::class, 'storeIssueRequest'])->name('issue-request.store');
        Route::get('/issues', [InventoryController::class, 'issues'])->name('issues');
        Route::post('/issues/store', [InventoryController::class, 'storeIssue'])->name('issue.store');
    });

    // Mobilization Management
   // Route::group(['prefix' => 'admin/mobilization', 'as' => 'admin.mobilization.'], function () {
     Route::prefix('mobilization')->name('mobilization.')->group(function () {  
        Route::get('/', [MobilizationController::class, 'index'])->name('index');
        Route::get('/create', [MobilizationController::class, 'create'])->name('create');
        Route::post('/store', [MobilizationController::class, 'store'])->name('store');
        Route::get('/{id}', [MobilizationController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [MobilizationController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [MobilizationController::class, 'update'])->name('update');
        Route::delete('/{id}', [MobilizationController::class, 'destroy'])->name('destroy');
        Route::post('/resource/store', [MobilizationController::class, 'storeResource'])->name('resource.store');
        Route::post('/checklist/store', [MobilizationController::class, 'storeChecklist'])->name('checklist.store');
    });

    // Document Management
  //  Route::group(['prefix' => 'admin/document', 'as' => 'admin.document.'], function () {
        Route::prefix('document')->name('document.')->group(function () {  
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::get('/create', [DocumentController::class, 'create'])->name('create');
        Route::post('/store', [DocumentController::class, 'store'])->name('store');
        Route::get('/categories', [DocumentController::class, 'categories'])->name('categories');
        Route::post('/categories/store', [DocumentController::class, 'storeCategory'])->name('category.store');
        Route::get('/{id}', [DocumentController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [DocumentController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [DocumentController::class, 'update'])->name('update');
        Route::delete('/{id}', [DocumentController::class, 'destroy'])->name('destroy');
    });

    // Health & Safety
   // Route::group(['prefix' => 'admin/hse', 'as' => 'admin.hse.'], function () {
   Route::prefix('hse')->name('hse.')->group(function () {  
        Route::get('/incidents', [HseController::class, 'incidents'])->name('incidents');
        Route::post('/incidents/store', [HseController::class, 'storeIncident'])->name('incident.store');
        Route::get('/inspections', [HseController::class, 'inspections'])->name('inspections');
        Route::post('/inspections/store', [HseController::class, 'storeInspection'])->name('inspection.store');
        Route::get('/ppe', [HseController::class, 'ppe'])->name('ppe');
        Route::post('/ppe/store', [HseController::class, 'storePpe'])->name('ppe.store');
    });

    // Finance Management
    //Route::group(['prefix' => 'admin/finance', 'as' => 'admin.finance.'], function () {
     Route::prefix('finance')->name('finance.')->group(function () {  
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('/payments', [FinanceController::class, 'payments'])->name('payments');
        Route::post('/payments/store', [FinanceController::class, 'storePayment'])->name('payment.store');
        Route::get('/expenses', [FinanceController::class, 'expenses'])->name('expenses');
        Route::post('/expenses/store', [FinanceController::class, 'storeExpense'])->name('expense.store');
        Route::get('/budgets', [FinanceController::class, 'budgets'])->name('budgets');
        Route::post('/budgets/store', [FinanceController::class, 'storeBudget'])->name('budget.store');
    });

    // Audit Logs
   // Route::group(['prefix' => 'admin/audit', 'as' => 'admin.audit.'], function () {
   Route::prefix('audit')->name('audit.')->group(function () {  
        Route::get('/', [AuditLogController::class, 'index'])->name('index');
        Route::get('/{id}', [AuditLogController::class, 'show'])->name('show');
    });

    // Reporting
   // Route::group(['prefix' => 'admin/report', 'as' => 'admin.report.'], function () {
   Route::prefix('report')->name('report.')->group(function () {  
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::post('/generate', [ReportController::class, 'generate'])->name('generate');
    });

    // Pre-Construction: Land Acquisition
   // Route::group(['prefix' => 'admin/land', 'as' => 'admin.land.'], function () {
    Route::prefix('land')->name('land.')->group(function () {  
        Route::get('/', [LandAcquisitionController::class, 'index'])->name('index');
        Route::get('/create', [LandAcquisitionController::class, 'create'])->name('create');
        Route::post('/store', [LandAcquisitionController::class, 'store'])->name('store');
        Route::get('/{id}', [LandAcquisitionController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [LandAcquisitionController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [LandAcquisitionController::class, 'update'])->name('update');
        Route::delete('/{id}', [LandAcquisitionController::class, 'destroy'])->name('destroy');
        Route::post('/owner/store', [LandAcquisitionController::class, 'storeOwner'])->name('owner.store');
        Route::post('/survey/store', [LandAcquisitionController::class, 'storeSurvey'])->name('survey.store');
        Route::post('/document/store', [LandAcquisitionController::class, 'storeDocument'])->name('document.store');
        Route::post('/payment/store', [LandAcquisitionController::class, 'storePayment'])->name('payment.store');
    });

    // Feasibility Studies
  //  Route::group(['prefix' => 'admin/feasibility', 'as' => 'admin.feasibility.'], function () {
  Route::prefix('feasibility')->name('feasibility.')->group(function () {   
  Route::get('/', [FeasibilityController::class, 'index'])->name('index');
        Route::get('/create', [FeasibilityController::class, 'create'])->name('create');
        Route::post('/store', [FeasibilityController::class, 'store'])->name('store');
        Route::get('/{id}', [FeasibilityController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [FeasibilityController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [FeasibilityController::class, 'update'])->name('update');
        Route::delete('/{id}', [FeasibilityController::class, 'destroy'])->name('destroy');
        Route::post('/soil/store', [FeasibilityController::class, 'storeSoilTest'])->name('soil.store');
        Route::post('/risk/store', [FeasibilityController::class, 'storeRisk'])->name('risk.store');
    });

    // Consultants (Design)
  //  Route::group(['prefix' => 'admin/consultant', 'as' => 'admin.consultant.'], function () {
   Route::prefix('consultant')->name('consultant.')->group(function () {
        Route::get('/', [ConsultantController::class, 'index'])->name('index');
        Route::get('/create', [ConsultantController::class, 'create'])->name('create');
        Route::post('/store', [ConsultantController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ConsultantController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [ConsultantController::class, 'update'])->name('update');
        Route::delete('/{id}', [ConsultantController::class, 'destroy'])->name('destroy');
    });
        Route::prefix('design')->name('design.')->group(function () {
             Route::get('/', [DesignController::class, 'index'])->name('index');
                Route::get('/packages', [DesignController::class, 'packages'])->name('packages.index');
                Route::get('/packages/create', [DesignController::class, 'createPackage'])->name('packages.create');
                Route::post('/packages/store', [DesignController::class, 'storePackage'])->name('packages.store');
                Route::get('/drawings', [DesignController::class, 'drawings'])->name('drawings.index');
                Route::get('/drawings/create', [DesignController::class, 'createDrawing'])->name('drawings.create');
                Route::post('/drawings/store', [DesignController::class, 'storeDrawing'])->name('drawings.store');
                Route::get('/drawings/{id}', [DesignController::class, 'showDrawing'])->name('drawings.show');
                Route::get('/boq', [DesignController::class, 'boqIndex'])->name('boq.index');
                Route::post('/boq/store', [DesignController::class, 'storeBoq'])->name('boq.store');
                Route::get('/rfis', [DesignController::class, 'rfiIndex'])->name('rfi.index');
                Route::post('/rfis/store', [DesignController::class, 'storeRfi'])->name('rfi.store');

          });
    });

});
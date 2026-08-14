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

    Route::get('/login', 'showLoginForm')
        ->name('login.form');

    Route::post('/login', 'login')
        ->middleware('throttle:10,1')
        ->name('login');

    Route::get('/register', 'showRegisterForm')
        ->name('register.form');

    Route::post('/register', 'register')
        ->name('register');

    Route::get('/forgot-password', 'showForgotForm')
        ->name('forgot.form');

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

            'proposal-units_view' =>
                $user->can('proposal-units.view'),

            'proposal-units_create' =>
                $user->can('proposal-units.create'),

            'proposal-units_edit' =>
                $user->can('proposal-units.edit'),

            'proposal-units_delete' =>
                $user->can('proposal-units.delete'),

            'is_super_admin' =>
                (bool) $user->is_super_admin,
        ];
    });


    Route::get('/debug-role', function () {

        $user = Auth::user();

        dd([
            'User' => $user,

            'Roles' =>
                $user->getRoleNames(),

            'Permissions' =>
                $user->getPermissionNames(),

            'All Permissions' =>
                $user->getAllPermissions()
                    ->pluck('name'),
        ]);
    });

});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Authentication / Profile
|--------------------------------------------------------------------------
*/

Route::prefix('auth')
    ->group(function () {

        Route::prefix('profile')
            ->name('profile.')
            ->group(function () {
                Route::get('/dashboard', [
                    AuthController::class,
                    'dashboard'
                ])->name('show');
                Route::get('/', [
                    AuthController::class,
                    'profileForm'
                ])
                    ->middleware('permission:profile.view')
                    ->name('show');

                Route::post('/update', [
                    AuthController::class,
                    'updateProfile'
                ])
                    ->middleware('permission:profile.update')
                    ->name('update');

                Route::post('/change-password', [
                    AuthController::class,
                    'changePassword'
                ])
                    ->middleware('permission:profile.update')
                    ->name('change-password');
            });
    });

Route::middleware('auth')->group(function () {




    /*
    |--------------------------------------------------------------------------
    | ADMIN PANEL
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {


            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get('/dashboard', [
                DashboardController::class,
                'index'
            ])
                ->middleware('permission:dashboard.view')
                ->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | User Management
            |--------------------------------------------------------------------------
            */

            Route::prefix('users')
                ->name('users.')
                ->group(function () {

                    Route::get('/', [
                        UserManagementController::class,
                        'index'
                    ])
                        ->middleware('permission:users.view')
                        ->name('index');


                    Route::get('/create', [
                        UserManagementController::class,
                        'create'
                    ])
                        ->middleware('permission:users.create')
                        ->name('create');


                    Route::post('/', [
                        UserManagementController::class,
                        'store'
                    ])
                        ->middleware('permission:users.create')
                        ->name('store');


                    Route::get('/{user}', [
                        UserManagementController::class,
                        'show'
                    ])
                        ->middleware('permission:users.view')
                        ->name('show');


                    Route::get('/{user}/edit', [
                        UserManagementController::class,
                        'edit'
                    ])
                        ->middleware('permission:users.edit')
                        ->name('edit');


                    Route::put('/{user}', [
                        UserManagementController::class,
                        'update'
                    ])
                        ->middleware('permission:users.edit')
                        ->name('update');


                    Route::delete('/{user}', [
                        UserManagementController::class,
                        'destroy'
                    ])
                        ->middleware('permission:users.delete')
                        ->name('destroy');


                    Route::post('/{user}/assign-role', [
                        UserManagementController::class,
                        'assignRole'
                    ])
                        ->middleware('permission:users.edit')
                        ->name('assign-role');


                    Route::post('/{user}/revoke-role', [
                        UserManagementController::class,
                        'revokeRole'
                    ])
                        ->middleware('permission:users.edit')
                        ->name('revoke-role');


                    Route::post('/{user}/activate', [
                        UserManagementController::class,
                        'activate'
                    ])
                        ->middleware('permission:users.edit')
                        ->name('activate');


                    Route::post('/{user}/deactivate', [
                        UserManagementController::class,
                        'deactivate'
                    ])
                        ->middleware('permission:users.edit')
                        ->name('deactivate');


                    Route::get('/{user}/audits', [
                        UserManagementController::class,
                        'audits'
                    ])
                        ->middleware('permission:audit.view')
                        ->name('audits');
                });


            /*
            |--------------------------------------------------------------------------
            | Role Management
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'roles',
                RoleController::class
            )
                ->middleware([
                    'index'   => 'permission:roles.view',
                    'show'    => 'permission:roles.view',
                    'create'  => 'permission:roles.create',
                    'store'   => 'permission:roles.create',
                    'edit'    => 'permission:roles.edit',
                    'update'  => 'permission:roles.edit',
                    'destroy' => 'permission:roles.delete',
                ]);

  Route::prefix('assets')
    ->name('assets.')
    ->group(function () {
            /*
            |--------------------------------------------------------------------------
            | Mall Management
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'malls',
                MallController::class
            )
                ->middleware([
                    'index'   => 'permission:malls.view',
                    'show'    => 'permission:malls.view',
                    'create'  => 'permission:malls.create',
                    'store'   => 'permission:malls.create',
                    'edit'    => 'permission:malls.edit',
                    'update'  => 'permission:malls.edit',
                    'destroy' => 'permission:malls.delete',
                ]);


            /*
            |--------------------------------------------------------------------------
            | Building Management
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'buildings',
                BuildingController::class
            )
                ->middleware([
                    'index'   => 'permission:buildings.view',
                    'show'    => 'permission:buildings.view',
                    'create'  => 'permission:buildings.create',
                    'store'   => 'permission:buildings.create',
                    'edit'    => 'permission:buildings.edit',
                    'update'  => 'permission:buildings.edit',
                    'destroy' => 'permission:buildings.delete',
                ]);


            /*
            |--------------------------------------------------------------------------
            | Floor Management
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'floors',
                FloorController::class
            )
                ->middleware([
                    'index'   => 'permission:floors.view',
                    'show'    => 'permission:floors.view',
                    'create'  => 'permission:floors.create',
                    'store'   => 'permission:floors.create',
                    'edit'    => 'permission:floors.edit',
                    'update'  => 'permission:floors.edit',
                    'destroy' => 'permission:floors.delete',
                ]);


            /*
            |--------------------------------------------------------------------------
            | Zone Management
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'zones',
                ZoneController::class
            )
                ->middleware([
                    'index'   => 'permission:zones.view',
                    'show'    => 'permission:zones.view',
                    'create'  => 'permission:zones.create',
                    'store'   => 'permission:zones.create',
                    'edit'    => 'permission:zones.edit',
                    'update'  => 'permission:zones.edit',
                    'destroy' => 'permission:zones.delete',
                ]);


            /*
            |--------------------------------------------------------------------------
            | Unit Type Management
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'unit-types',
                UnitTypeController::class
            )
                ->middleware([
                    'index'   => 'permission:unit_types.view',
                    'show'    => 'permission:unit_types.view',
                    'create'  => 'permission:unit_types.create',
                    'store'   => 'permission:unit_types.create',
                    'edit'    => 'permission:unit_types.edit',
                    'update'  => 'permission:unit_types.edit',
                    'destroy' => 'permission:unit_types.delete',
                ]);

   
        // Units resource routes added by automated change
        Route::resource('units', App\Http\Controllers\Admin\Assets\UnitController::class)
            ->middleware([
                'index' => 'permission:units.view',
                'show' => 'permission:units.view',
                'create' => 'permission:units.create',
                'store' => 'permission:units.create',
                'edit' => 'permission:units.edit',
                'update' => 'permission:units.edit',
                'destroy' => 'permission:units.delete',
            ]);

          // Units status resource routes added by automated change
        Route::resource('unit-statuses', App\Http\Controllers\Admin\Assets\UnitStatusController::class)
            ->middleware([
                'index' => 'permission:unit_statuses.view',
                'show' => 'permission:unit_statuses.view',
                'create' => 'permission:unit_statuses.create',
                'store' => 'permission:unit_statuses.create',
                'edit' => 'permission:unit_statuses.edit',
                'update' => 'permission:unit_statuses.edit',
                'destroy' => 'permission:unit_statuses.delete',
            ]);
        });
    });
});

/*Leasing*/


    Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Leasing
        |--------------------------------------------------------------------------
        */

        Route::prefix('leasing')
            ->name('leasing.')
            ->group(function () {

                /*
                |--------------------------------------------------------------------------
                | Lease Proposals
                |--------------------------------------------------------------------------
                */

                Route::resource(
                    'proposals',
                    LeaseProposalController::class
                );

                Route::post(
                    'proposals/{id}/submit',
                    [
                        LeaseProposalController::class,
                        'submit'
                    ]
                )->name('proposals.submit');

                Route::post(
                    'proposals/{id}/approve',
                    [
                        LeaseProposalController::class,
                        'approve'
                    ]
                )->name('proposals.approve');

                Route::post(
                    'proposals/{id}/reject',
                    [
                        LeaseProposalController::class,
                        'reject'
                    ]
                )->name('proposals.reject');

                Route::post(
                    'agreements/{id}/activate',
                    [
                        LeaseAgreementController::class,
                        'activate'
                    ]
                )->name('agreements.activate');


                /*
                |--------------------------------------------------------------------------
                | Lease Agreements
                |--------------------------------------------------------------------------
                */

                Route::resource(
                    'agreements',
                    LeaseAgreementController::class
                );

                Route::resource(
                    'terms',
                    LeaseTermController::class
                );


                Route::resource(
                    'documents',
                    LeaseDocumentController::class
                );

                Route::post(
                    'documents/{document}/verify',
                    [
                        LeaseDocumentController::class,
                        'verify'
                    ]
                )->name('documents.verify');

                Route::post(
                    'documents/{document}/reject',
                    [
                        LeaseDocumentController::class,
                        'reject'
                    ]
                )->name('documents.reject');

                Route::get(
                    'agreements/{agreement}/renew',
                    [
                        LeaseAgreementController::class,
                        'renew'
                    ]
                )->name('agreements.renew');

                Route::post(
                    'agreements/{agreement}/renew',
                    [
                        LeaseAgreementController::class,
                        'processRenewal'
                    ]
                )->name('agreements.process-renewal');

                /*Route::resource(
                    'renewals',
                    LeaseRenewalController::class
                )->only([
                    'index',
                    'create',
                    'store',
                    'show',
                ]);*/

                Route::resource(
                    'renewals',
                    LeaseRenewalController::class
                )->only([
                    'index',
                    'create',
                    'store',
                    'show',
                    'edit',
                    'update',
                ]);

                Route::post(
                    'renewals/{renewal}/submit',
                    [LeaseRenewalController::class, 'submit']
                )->name('renewals.submit');


                Route::post(
                    'renewals/{renewal}/approve',
                    [LeaseRenewalController::class, 'approve']
                )->name('renewals.approve');


                Route::post(
                    'renewals/{renewal}/reject',
                    [LeaseRenewalController::class, 'reject']
                )->name('renewals.reject');


                Route::post(
                    'renewals/{renewal}/cancel',
                    [LeaseRenewalController::class, 'cancel']
                )->name('renewals.cancel');

                Route::get(
                    'renewals/{renewal}/convert',
                    [LeaseRenewalController::class, 'convert']
                )->name('renewals.convert');

                Route::post(
                    'renewals/{renewal}/convert',
                    [LeaseRenewalController::class, 'convertStore']
                )->name('renewals.convert.store');


                Route::resource(
                    'escalations',
                    LeaseEscalationController::class
                )->only([
                    'index',
                    'create',
                    'store',
                    'show',
                ]);


                Route::post(
                    'escalations/{escalation}/approve',
                    [
                        LeaseEscalationController::class,
                        'approve'
                    ]
                )->name('escalations.approve');


                Route::post(
                    'escalations/{escalation}/cancel',
                    [
                        LeaseEscalationController::class,
                        'cancel'
                    ]
                )->name('escalations.cancel');

                Route::get(
                    'history',
                    [
                        LeaseHistoryController::class,
                        'index'
                    ]
                )->name('history.index');


                Route::resource(
                    'terminations',
                    LeaseTerminationController::class
                );

                Route::post(
                    'terminations/{id}/submit',
                    [
                        LeaseTerminationController::class,
                        'submit'
                    ]
                )->name('terminations.submit');

                Route::post(
                    'terminations/{id}/approve',
                    [
                        LeaseTerminationController::class,
                        'approve'
                    ]
                )->name('terminations.approve');

                Route::post(
                    'terminations/{id}/cancel',
                    [
                        LeaseTerminationController::class,
                        'cancel'
                    ]
                )->name('terminations.cancel');


                Route::post(
                    'terminations/{id}/complete-inspection',
                    [LeaseTerminationController::class, 'completeInspection']
                )->name('terminations.completeInspection');

                Route::post(
                    'terminations/{id}/complete-handover',
                    [LeaseTerminationController::class, 'completeHandover']
                )->name('terminations.completeHandover');

                Route::post(
                    'terminations/{id}/complete',
                    [LeaseTerminationController::class, 'complete']
                )->name('terminations.complete');

                Route::get(
                    'dashboard',
                    [
                        LeaseDashboardController::class,
                        'index'
                    ]
                )->name('dashboard');


            });


            /*Route::prefix('tenants')
            ->name('tenants.')
            ->group(function () {

                Route::get(
                    'dashboard',
                    [
                        TenantDashboardController::class,
                        'index'
                    ]
                )->name('dashboard');

            });*/

            Route::get(
                'tenants/dashboard',
                [
                    TenantDashboardController::class,
                    'index'
                ]
            )->name('tenants.dashboard');


            /*
            |--------------------------------------------------------------------------
            | Tenant CRUD
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'tenants',
                TenantController::class
            );

            /*
            |--------------------------------------------------------------------------
            | Tenant Contacts
            |--------------------------------------------------------------------------
            */

            Route::get(
                'tenants/{tenant}/contacts',
                [
                    TenantContactController::class,
                    'index'
                ]
            )->name('tenants.contacts.index');

            Route::post(
                'tenants/{tenant}/contacts',
                [
                    TenantContactController::class,
                    'store'
                ]
            )->name('tenants.contacts.store');

            Route::get(
                'tenants/{tenant}/contacts/{contact}/edit',
                [
                    TenantContactController::class,
                    'edit'
                ]
            )->name('tenants.contacts.edit');

            Route::put(
                'tenants/{tenant}/contacts/{contact}',
                [
                    TenantContactController::class,
                    'update'
                ]
            )->name('tenants.contacts.update');

            Route::delete(
                'tenants/{tenant}/contacts/{contact}',
                [
                    TenantContactController::class,
                    'destroy'
                ]
            )->name('tenants.contacts.destroy');

            /*
            |--------------------------------------------------------------------------
            | Tenant Addresses
            |--------------------------------------------------------------------------
            */

            Route::get(
                'tenants/{tenant}/addresses',
                [
                    TenantAddressController::class,
                    'index'
                ]
            )->name('tenants.addresses.index');

            Route::post(
                'tenants/{tenant}/addresses',
                [
                    TenantAddressController::class,
                    'store'
                ]
            )->name('tenants.addresses.store');

            Route::get(
                'tenants/{tenant}/addresses/{address}/edit',
                [
                    TenantAddressController::class,
                    'edit'
                ]
            )->name('tenants.addresses.edit');

            Route::put(
                'tenants/{tenant}/addresses/{address}',
                [
                    TenantAddressController::class,
                    'update'
                ]
            )->name('tenants.addresses.update');

            Route::delete(
                'tenants/{tenant}/addresses/{address}',
                [
                    TenantAddressController::class,
                    'destroy'
                ]
            )->name('tenants.addresses.destroy');

            /*
            |--------------------------------------------------------------------------
            | Tenant Bank Accounts
            |--------------------------------------------------------------------------
            */

            Route::get(
                'tenants/{tenant}/bank-accounts',
                [
                    TenantBankAccountController::class,
                    'index'
                ]
            )->name('tenants.bank-accounts.index');


            Route::post(
                'tenants/{tenant}/bank-accounts',
                [
                    TenantBankAccountController::class,
                    'store'
                ]
            )->name('tenants.bank-accounts.store');


            Route::get(
                'tenants/{tenant}/bank-accounts/{account}/edit',
                [
                    TenantBankAccountController::class,
                    'edit'
                ]
            )->name('tenants.bank-accounts.edit');


            Route::put(
                'tenants/{tenant}/bank-accounts/{account}',
                [
                    TenantBankAccountController::class,
                    'update'
                ]
            )->name('tenants.bank-accounts.update');


            Route::delete(
                'tenants/{tenant}/bank-accounts/{account}',
                [
                    TenantBankAccountController::class,
                    'destroy'
                ]
            )->name('tenants.bank-accounts.destroy');

            /*
            |--------------------------------------------------------------------------
            | Tenant Documents
            |--------------------------------------------------------------------------
            */

            Route::get(
                'tenants/{tenant}/documents',
                [
                    TenantDocumentController::class,
                    'index'
                ]
            )->name('tenants.documents.index');


            Route::post(
                'tenants/{tenant}/documents',
                [
                    TenantDocumentController::class,
                    'store'
                ]
            )->name('tenants.documents.store');


            Route::get(
                'tenants/{tenant}/documents/{document}/edit',
                [
                    TenantDocumentController::class,
                    'edit'
                ]
            )->name('tenants.documents.edit');


            Route::put(
                'tenants/{tenant}/documents/{document}',
                [
                    TenantDocumentController::class,
                    'update'
                ]
            )->name('tenants.documents.update');


            Route::delete(
                'tenants/{tenant}/documents/{document}',
                [
                    TenantDocumentController::class,
                    'destroy'
                ]
            )->name('tenants.documents.destroy');

            /*
            |--------------------------------------------------------------------------
            | Tenant Emergency Contacts
            |--------------------------------------------------------------------------
            */

            Route::get(
                'tenants/{tenant}/emergency-contacts',
                [
                    TenantEmergencyContactController::class,
                    'index'
                ]
            )->name('tenants.emergency-contacts.index');


            Route::post(
                'tenants/{tenant}/emergency-contacts',
                [
                    TenantEmergencyContactController::class,
                    'store'
                ]
            )->name('tenants.emergency-contacts.store');


            Route::get(
                'tenants/{tenant}/emergency-contacts/{contact}/edit',
                [
                    TenantEmergencyContactController::class,
                    'edit'
                ]
            )->name('tenants.emergency-contacts.edit');


            Route::put(
                'tenants/{tenant}/emergency-contacts/{contact}',
                [
                    TenantEmergencyContactController::class,
                    'update'
                ]
            )->name('tenants.emergency-contacts.update');


            Route::delete(
                'tenants/{tenant}/emergency-contacts/{contact}',
                [
                    TenantEmergencyContactController::class,
                    'destroy'
                ]
            )->name('tenants.emergency-contacts.destroy');

            /*
            |--------------------------------------------------------------------------
            | Tenant Notes
            |--------------------------------------------------------------------------
            */

            Route::get(
                'tenants/{tenant}/notes',
                [
                    TenantNoteController::class,
                    'index'
                ]
            )->name('tenants.notes.index');


            Route::post(
                'tenants/{tenant}/notes',
                [
                    TenantNoteController::class,
                    'store'
                ]
            )->name('tenants.notes.store');


            Route::get(
                'tenants/{tenant}/notes/{note}/edit',
                [
                    TenantNoteController::class,
                    'edit'
                ]
            )->name('tenants.notes.edit');


            Route::put(
                'tenants/{tenant}/notes/{note}',
                [
                    TenantNoteController::class,
                    'update'
                ]
            )->name('tenants.notes.update');


            Route::delete(
                'tenants/{tenant}/notes/{note}',
                [
                    TenantNoteController::class,
                    'destroy'
                ]
            )->name('tenants.notes.destroy');

            /*
            |--------------------------------------------------------------------------
            | Tenant History
            |--------------------------------------------------------------------------
            */

            Route::get(
                'tenants/{tenant}/history',
                [
                    TenantHistoryController::class,
                    'index'
                ]
            )->name('tenants.history.index');


            Route::prefix('revenue')
                ->name('revenue.')
                ->group(function () {

                    Route::get(
                        'tax-configurations',
                        [
                            TaxConfigurationController::class,
                            'index'
                        ]
                    )->name(
                        'tax-configurations.index'
                    );

                    Route::post(
                        'tax-configurations',
                        [
                            TaxConfigurationController::class,
                            'store'
                        ]
                    )->name(
                        'tax-configurations.store'
                    );

                    Route::get(
                        'tax-configurations/{id}/edit',
                        [
                            TaxConfigurationController::class,
                            'edit'
                        ]
                    )->name(
                        'tax-configurations.edit'
                    );

                    Route::put(
                        'tax-configurations/{id}',
                        [
                            TaxConfigurationController::class,
                            'update'
                        ]
                    )->name(
                        'tax-configurations.update'
                    );

                    Route::delete(
                        'tax-configurations/{id}',
                        [
                            TaxConfigurationController::class,
                            'destroy'
                        ]
                    )->name(
                        'tax-configurations.destroy'
                    );

            });

            Route::prefix('revenue')
                ->name('revenue.')
                ->group(function () {

                    /*
                    |--------------------------------------------------------------------------
                    | Deposits
                    |--------------------------------------------------------------------------
                    */

                    Route::get(
                        'deposits',
                        [
                            DepositController::class,
                            'index'
                        ]
                    )->name(
                        'deposits.index'
                    );

                    Route::post(
                        'deposits',
                        [
                            DepositController::class,
                            'store'
                        ]
                    )->name(
                        'deposits.store'
                    );

                    Route::get(
                        'deposits/{id}/edit',
                        [
                            DepositController::class,
                            'edit'
                        ]
                    )->name(
                        'deposits.edit'
                    );

                    Route::put(
                        'deposits/{id}',
                        [
                            DepositController::class,
                            'update'
                        ]
                    )->name(
                        'deposits.update'
                    );

                    Route::delete(
                        'deposits/{id}',
                        [
                            DepositController::class,
                            'destroy'
                        ]
                    )->name(
                        'deposits.destroy'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Deposit Receipts
                    |--------------------------------------------------------------------------
                    */

                    Route::get(
                        'deposit-receipts',
                        [
                            DepositReceiptController::class,
                            'index'
                        ]
                    )->name(
                        'deposit-receipts.index'
                    );

                    Route::get(
                        'deposits/{deposit}/receipts',
                        [
                            DepositReceiptController::class,
                            'index'
                        ]
                    )->name(
                        'deposits.receipts'
                    );

                    Route::post(
                        'deposit-receipts',
                        [
                            DepositReceiptController::class,
                            'store'
                        ]
                    )->name(
                        'deposit-receipts.store'
                    );

                    Route::get(
                        'deposit-receipts/{id}/edit',
                        [
                            DepositReceiptController::class,
                            'edit'
                        ]
                    )->name(
                        'deposit-receipts.edit'
                    );

                    Route::put(
                        'deposit-receipts/{id}',
                        [
                            DepositReceiptController::class,
                            'update'
                        ]
                    )->name(
                        'deposit-receipts.update'
                    );

                    Route::delete(
                        'deposit-receipts/{id}',
                        [
                            DepositReceiptController::class,
                            'destroy'
                        ]
                    )->name(
                        'deposit-receipts.destroy'
                    );

                    Route::post(
                        'deposit-receipts/{id}/reverse',
                        [
                            DepositReceiptController::class,
                            'reverse'
                        ]
                    )->name(
                        'deposit-receipts.reverse'
                    );

                    Route::post(
                        'deposit-receipts/{id}/confirm',
                        [DepositReceiptController::class, 'confirm']
                    )->name('admin.revenue.deposit-receipts.confirm');


                    /*
                    |--------------------------------------------------------------------------
                    | Deposit Refunds
                    |--------------------------------------------------------------------------
                    */

                    Route::get(
                        'deposit-refunds',
                        [
                            DepositRefundController::class,
                            'index'
                        ]
                    )->name(
                        'deposit-refunds.index'
                    );

                    Route::post(
                        'deposit-refunds',
                        [
                            DepositRefundController::class,
                            'store'
                        ]
                    )->name(
                        'deposit-refunds.store'
                    );

                    Route::post(
                        'deposit-refunds/{id}/approve',
                        [
                            DepositRefundController::class,
                            'approve'
                        ]
                    )->name(
                        'deposit-refunds.approve'
                    );

                    Route::post(
                        'deposit-refunds/{id}/process',
                        [
                            DepositRefundController::class,
                            'process'
                        ]
                    )->name(
                        'deposit-refunds.process'
                    );

                    Route::post(
                        'deposit-refunds/{id}/cancel',
                        [
                            DepositRefundController::class,
                            'cancel'
                        ]
                    )->name(
                        'deposit-refunds.cancel'
                    );


                    Route::get(
                        '/rent-schedules',
                        [RentScheduleController::class, 'index']
                    )->name('rent-schedules.index');

                    Route::post(
                        '/rent-schedules/generate/{agreementId}',
                        [RentScheduleController::class, 'generate']
                    )->name('rent-schedules.generate');

                    Route::post(
                        '/rent-schedules/{id}/generate-invoice',
                        [RentScheduleController::class, 'generateInvoice']
                    )->name('rent-schedules.generate-invoice');

                    Route::get(
                        '/rent-schedules/{id}',
                        [RentScheduleController::class, 'show']
                    )->name('rent-schedules.show');

                    Route::get('/invoices', [InvoiceController::class, 'index'])
                        ->name('invoices.index');

                    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])
                        ->name('invoices.show');

                    Route::get('/invoices/{id}/payment/create', [
                        RentPaymentController::class,
                        'create'
                    ])->name('payments.create');

                    Route::post('/invoices/{id}/payment', [
                        RentPaymentController::class,
                        'store'
                    ])->name('payments.store');

                    Route::get(
                        '/invoices/{id}/print',
                        [InvoiceController::class, 'print']
                    )->name('invoices.print');

                    Route::get('/payments', [
                        RentPaymentController::class,
                        'index'
                    ])->name('payments.index');

                    Route::get('/payments/{id}', [
                        RentPaymentController::class,
                        'show'
                    ])->name('payments.show');

                    Route::post('/payments/{id}/confirm', [
                        RentPaymentController::class,
                        'confirm'
                    ])->name('payments.confirm');

                    Route::post(
                        '/payments/{id}/reverse',
                        [RentPaymentController::class, 'reverse']
                    )->name('payments.reverse');

                    Route::post(
                        '/payments/{id}/reconcile',
                        [RentPaymentController::class, 'reconcile']
                    )->name('payments.reconcile');

                    Route::get(
                        '/payments/{id}/receipt',
                        [RentPaymentController::class, 'receipt']
                    )->name('payments.receipt');

                    Route::get(
                        '/dashboard',
                        [RevenueDashboardController::class, 'index']
                    )->name('dashboard');

                    Route::get(
                        '/outstanding',
                        [OutstandingController::class, 'index']
                    )->name('outstanding.index');

                    Route::get(
                        '/outstanding/overdue',
                        [OutstandingController::class, 'overdue']
                    )->name('outstanding.overdue');

                    Route::get(
                        '/outstanding/tenants',
                        [OutstandingController::class, 'tenants']
                    )->name('outstanding.tenants');

                    Route::get(
                        '/reports/revenue',
                        [RevenueReportController::class, 'index']
                    )->name('reports.revenue');

                    Route::get(
                        '/reports/collections',
                        [RevenueReportController::class, 'collections']
                    )->name('reports.collections');

                    Route::get(
                        '/reports/charge-wise',
                        [RevenueReportController::class, 'chargeWise']
                    )->name('reports.charge-wise');

                    Route::get(
                        '/reports/tenant-wise',
                        [RevenueReportController::class, 'tenantWise']
                    )->name('reports.tenant-wise');

                    Route::get(
                        '/reports/aging',
                        [RevenueReportController::class, 'aging']
                    )->name('reports.aging');

                    Route::prefix('settings/charge-types')
                        ->name('settings.charge-types.')
                        ->group(function () {

                            Route::get(
                                '/',
                                [ChargeTypeController::class, 'index']
                            )->name('index');

                            Route::get(
                                '/create',
                                [ChargeTypeController::class, 'create']
                            )->name('create');

                            Route::post(
                                '/',
                                [ChargeTypeController::class, 'store']
                            )->name('store');

                            Route::get(
                                '/{id}/edit',
                                [ChargeTypeController::class, 'edit']
                            )->name('edit');

                            Route::put(
                                '/{id}',
                                [ChargeTypeController::class, 'update']
                            )->name('update');

                            Route::delete(
                                '/{id}',
                                [ChargeTypeController::class, 'destroy']
                            )->name('destroy');

                    });

                    Route::prefix('reconciliation')
                    ->name('reconciliation.')
                    ->group(function () {

                        Route::get(
                            '/',
                            [ReconciliationController::class, 'index']
                        )->name('index');

                        Route::post(
                            '/{id}/reconcile',
                            [ReconciliationController::class, 'reconcile']
                        )->name('reconcile');

                    });

                    Route::get(
                        '/audit-log',
                        [RevenueAuditLogController::class, 'index']
                    )->name('audit.index');

            });

            Route::prefix('fitout')
                ->name('fitout.')
                ->group(function () {

                    Route::get(
                        '/dashboard',
                        [FitoutDashboardController::class, 'index']
                    )->name('dashboard');

                    Route::get(
                        'requests',
                        [FitoutRequestController::class, 'index']
                    )->name('requests.index');

                    Route::get(
                        'requests/create',
                        [FitoutRequestController::class, 'create']
                    )->name('requests.create');

                    Route::post(
                        'requests',
                        [FitoutRequestController::class, 'store']
                    )->name('requests.store');

                    Route::get(
                        'requests/{id}',
                        [FitoutRequestController::class, 'show']
                    )->name('requests.show');

                    Route::post(
                        'requests/{id}/submit',
                        [FitoutRequestController::class, 'submit']
                    )->name('requests.submit');

                    Route::post(
                        'requests/{id}/start-review',
                        [FitoutRequestController::class, 'startReview']
                    )->name('requests.startReview');

                    Route::post(
                        'requests/{id}/approve',
                        [FitoutRequestController::class, 'approve']
                    )->name('requests.approve');

                    Route::post(
                        'requests/{id}/reject',
                        [FitoutRequestController::class, 'reject']
                    )->name('requests.reject');

                    Route::post(
                        'requests/{id}/start',
                        [FitoutRequestController::class, 'start']
                    )->name('requests.start');

                    Route::post(
                        'requests/{id}/complete',
                        [FitoutRequestController::class, 'complete']
                    )->name('requests.complete');

                    Route::post(
                        'requests/{id}/close',
                        [FitoutRequestController::class, 'close']
                    )->name('requests.close');

                    Route::post(
                        '/requests/{id}/generate-approval',
                        [
                            FitoutRequestController::class,
                            'generateApproval'
                        ]
                    )->name('requests.generate-approval');

                    /*Route::get(
                        'requests/{id}/edit',
                        [FitoutRequestController::class, 'edit']
                    )->name('requests.edit');

                    Route::put(
                        'requests/{id}',
                        [FitoutRequestController::class, 'update']
                    )->name('requests.update');

                    Route::post(
                        'requests/{id}/submit',
                        [FitoutRequestController::class, 'submit']
                    )->name('requests.submit');

                    Route::delete(
                        'requests/{id}',
                        [FitoutRequestController::class, 'destroy']
                    )->name('requests.destroy');

                    Route::get(
                        '/agreements/{id}/details',
                        [FitoutRequestController::class, 'agreementDetails']
                    )->name('agreements.details');*/


                    /*Contractor Route*/
                    Route::get(
                        'contractors',
                        [ContractorController::class, 'index']
                    )->name('contractors.index');

                    Route::get(
                        'contractors/create',
                        [ContractorController::class, 'create']
                    )->name('contractors.create');

                    Route::post(
                        'contractors',
                        [ContractorController::class, 'store']
                    )->name('contractors.store');

                    Route::get(
                        'contractors/{id}',
                        [ContractorController::class, 'show']
                    )->name('contractors.show');

                    Route::get(
                        'contractors/{id}/edit',
                        [ContractorController::class, 'edit']
                    )->name('contractors.edit');
                    Route::put(
                        'contractors/{id}',
                        [ContractorController::class, 'update']
                    )->name('contractors.update');
                    Route::post(
                        'contractors/{id}/approve',
                        [ContractorController::class, 'approve']
                    )->name('contractors.approve');

                    Route::post(
                        'contractors/{id}/reject',
                        [ContractorController::class, 'reject']
                    )->name('contractors.reject');

                    Route::post(
                        'contractors/{id}/suspend',
                        [ContractorController::class, 'suspend']
                    )->name('contractors.suspend');

                    /*
                    |--------------------------------------------------------------------------
                    | FIT-OUT STAGES
                    |--------------------------------------------------------------------------
                    */

                    Route::get(
                        'requests/{fitoutRequestId}/stages',
                        [FitoutStageController::class, 'index']
                    )->name('stages.index');

                    Route::get(
                        'stages/{id}',
                        [FitoutStageController::class, 'show']
                    )->name('stages.show');

                    Route::post(
                        'stages/{id}/start',
                        [FitoutStageController::class, 'start']
                    )->name('stages.start');

                    Route::post(
                        'stages/{id}/progress',
                        [FitoutStageController::class, 'updateProgress']
                    )->name('stages.progress');

                    Route::post(
                        'stages/{id}/complete',
                        [FitoutStageController::class, 'complete']
                    )->name('stages.complete');

                    Route::post(
                        'stages/{id}/hold',
                        [FitoutStageController::class, 'hold']
                    )->name('stages.hold');

                    Route::post(
                        'stages/{id}/resume',
                        [FitoutStageController::class, 'resume']
                    )->name('stages.resume');

                    Route::get(
                        'stages/{id}/edit',
                        [FitoutStageController::class, 'edit']
                    )->name('stages.edit');

                    Route::put(
                        'stages/{id}',
                        [FitoutStageController::class, 'update']
                    )->name('stages.update');

                    /*Documents*/

                    Route::resource(
                        'documents',
                        FitoutDocumentController::class
                    )->names('documents');


                    Route::get('/documents/{id}/review', [
                        FitoutDocumentController::class,
                        'review'
                    ])->name('documents.review');

                    Route::post('/documents/{id}/start-review', [
                        FitoutDocumentController::class,
                        'startReview'
                    ])->name('documents.start-review');

                    Route::post('/documents/{id}/approve', [
                        FitoutDocumentController::class,
                        'approve'
                    ])->name('documents.approve');

                    Route::post('/documents/{id}/reject', [
                        FitoutDocumentController::class,
                        'reject'
                    ])->name('documents.reject');

                    /*Approvals*/
                    Route::get('/approvals', [
                        FitoutApprovalController::class,
                        'index'
                    ])->name('approvals.index');

                    Route::get('/approvals/pending', [
                        FitoutApprovalController::class,
                        'pending'
                    ])->name('approvals.pending');

                    Route::get('/approvals/{id}', [
                        FitoutApprovalController::class,
                        'show'
                    ])->name('approvals.show');

                    Route::post('/approvals/generate/{fitoutRequestId}', [
                        FitoutApprovalController::class,
                        'generate'
                    ])->name('approvals.generate');

                    Route::post('/approvals/{id}/approve', [
                        FitoutApprovalController::class,
                        'approve'
                    ])->name('approvals.approve');

                    Route::post('/approvals/{id}/reject', [
                        FitoutApprovalController::class,
                        'reject'
                    ])->name('approvals.reject');

                    /*insepections*/

                     Route::get('/inspections', [
                        FitoutInspectionController::class,
                        'index'
                    ])->name('inspections.index');

                    Route::get('/inspections/create', [
                        FitoutInspectionController::class,
                        'create'
                    ])->name('inspections.create');

                    Route::post('/inspections', [
                        FitoutInspectionController::class,
                        'store'
                    ])->name('inspections.store');

                    Route::get('/inspections/{id}', [
                        FitoutInspectionController::class,
                        'show'
                    ])->name('inspections.show');

                    Route::get('/inspections/{id}/edit', [
                        FitoutInspectionController::class,
                        'edit'
                    ])->name('inspections.edit');

                    Route::put('/inspections/{id}', [
                        FitoutInspectionController::class,
                        'update'
                    ])->name('inspections.update');

                    Route::post('/inspections/{id}/start', [
                        FitoutInspectionController::class,
                        'start'
                    ])->name('inspections.start');

                    Route::post('/inspections/{id}/complete', [
                        FitoutInspectionController::class,
                        'complete'
                    ])->name('inspections.complete');

                    Route::post('/inspections/{id}/cancel', [
                        FitoutInspectionController::class,
                        'cancel'
                    ])->name('inspections.cancel');

                    Route::post('/inspections/{id}/reschedule', [
                        FitoutInspectionController::class,
                        'reschedule'
                    ])->name('inspections.reschedule');

                    Route::get('/inspections/{id}/reinspection', [
                        FitoutInspectionController::class,
                        'createReinspection'
                    ])->name('inspections.reinspection.create');

                    Route::post('/inspections/{id}/reinspection', [
                        FitoutInspectionController::class,
                        'storeReinspection'
                    ])->name('inspections.reinspection.store');

                    Route::resource(
                        'snags',
                        SnagListController::class
                    )->names('snags');

                    Route::post(
                        'snags/{id}/resolve',
                        [SnagListController::class, 'resolve']
                    )->name('snags.resolve');

                    Route::post(
                        'snags/{id}/verify',
                        [SnagListController::class, 'verify']
                    )->name('snags.verify');

                    Route::post(
                        'snags/{id}/start-verification',
                        [SnagListController::class, 'startVerification']
                    )->name('snags.start-verification');

                    /*Handover*/
                    Route::resource(
                        'handovers',
                        HandoverController::class
                    )->names('handovers');

                    Route::post(
                        'handovers/{handover}/schedule',
                        [HandoverController::class, 'schedule']
                    )->name('handovers.schedule');


                    Route::post(
                        'handovers/{handover}/start',
                        [HandoverController::class, 'start']
                    )->name('handovers.start');


                    Route::post(
                        'handovers/{handover}/tenant-accept',
                        [HandoverController::class, 'tenantAccept']
                    )->name('handovers.tenant-accept');


                    Route::post(
                        'handovers/{handover}/contractor-accept',
                        [HandoverController::class, 'contractorAccept']
                    )->name('handovers.contractor-accept');


                    Route::post(
                        'handovers/{handover}/approve',
                        [HandoverController::class, 'approve']
                    )->name('handovers.approve');


                    Route::post(
                        'handovers/{handover}/complete',
                        [HandoverController::class, 'complete']
                    )->name('handovers.complete');

                    Route::get(
                        'handovers/{handover}/certificate',
                        [HandoverController::class, 'certificate']
                    )->name('handovers.certificate');



            });

    });


/*Revenue*/


    Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
                Route::prefix('revenue')
            ->name('revenue.')
            ->group(function () {   
                Route::get(
                    'dashboard',
                    [
                        App\Http\Controllers\Admin\Revenue\RevenueDashboardController::class,
                        'index'
                    ]
                )->name('dashboard');

                Route::resource('invoices', App\Http\Controllers\Admin\Revenue\InvoiceController::class);

                Route::resource('payments', App\Http\Controllers\Admin\Revenue\PaymentController::class);

                Route::resource('receipts', App\Http\Controllers\Admin\Revenue\DepositReceiptController::class);

                Route::resource('credit-notes', App\Http\Controllers\Admin\Revenue\DepositController::class);

                Route::resource('debit-notes', App\Http\Controllers\Admin\Revenue\CamChargeController::class);
                Route::resource('deposit_receipts', App\Http\Controllers\Admin\Revenue\DepositReceiptController::class);

            });


    });
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


            Route::prefix('tenants')
            ->name('tenants.')
            ->group(function () {

                Route::get(
                    'dashboard',
                    [
                        TenantDashboardController::class,
                        'index'
                    ]
                )->name('dashboard');

            });

    });



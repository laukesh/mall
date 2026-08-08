<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\MallController;
use App\Http\Controllers\Admin\BuildingController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/debug-building', function () {
    $user = auth()->user();

    return [
        'id' => $user->id,
        'name' => $user->name,

        'roles' => $user->getRoleNames(),

        'building_view' => $user->can('buildings.view'),
        'building_create' => $user->can('buildings.create'),
        'building_edit' => $user->can('buildings.edit'),
        'building_delete' => $user->can('buildings.delete'),

        'is_super_admin' => $user->is_super_admin,
    ];
})->middleware('auth');
Route::get('/debug-role', function () {
    $user = Auth::user();

    dd([
        'User'            => $user,
        'Roles'           => $user?->getRoleNames(),
        'Permissions'     => $user?->getPermissionNames(),
        'All Permissions' => $user?->getAllPermissions()->pluck('name'),
    ]);
})->middleware('auth');

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
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::prefix('profile')->name('profile.')->group(function () {
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

    /*
    |--------------------------------------------------------------------------
    | Administrator Panel
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->name('admin.')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->middleware('permission:dashboard.view')
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | User Management
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | Role Management
        |--------------------------------------------------------------------------
        */

        Route::resource('roles', RoleController::class)
            ->middleware([
                'index'   => 'permission:roles.view',
                'show'    => 'permission:roles.view',
                'create'  => 'permission:roles.create',
                'store'   => 'permission:roles.create',
                'edit'    => 'permission:roles.edit',
                'update'  => 'permission:roles.edit',
                'destroy' => 'permission:roles.delete',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Mall Management
        |--------------------------------------------------------------------------
        */

        Route::resource('malls', MallController::class)
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

        Route::resource('buildings', BuildingController::class)
            ->middleware([
                'index'   => 'permission:buildings.view',
                'show'    => 'permission:buildings.view',
                'create'  => 'permission:buildings.create',
                'store'   => 'permission:buildings.create',
                'edit'    => 'permission:buildings.edit',
                'update'  => 'permission:buildings.edit',
                'destroy' => 'permission:buildings.delete',
            ]);
    });
});
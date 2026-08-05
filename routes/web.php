<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\MallController as AdminMallController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.form');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('throttle:5,1')->name('password.email');

// Logout (supports GET for confirmation/compat, but prefer POST from UI)
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Profile
Route::get('/profile', [AuthController::class, 'profileForm'])->name('profile.form')->middleware('auth');
Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password')->middleware('auth');

// Legacy admin actions on AuthController (protected)
Route::post('/users/{id}/assign-role', [AuthController::class, 'assignRole'])->name('users.assign')->middleware('auth','can:manage-users');
Route::post('/users/{id}/revoke-role', [AuthController::class, 'revokeRole'])->name('users.revoke')->middleware('auth','can:manage-users');
Route::post('/users/{id}/activate', [AuthController::class, 'activate'])->name('users.activate')->middleware('auth','can:manage-users');
Route::post('/users/{id}/deactivate', [AuthController::class, 'deactivate'])->name('users.deactivate')->middleware('auth','can:manage-users');
Route::get('/users/statuses', [AuthController::class, 'statuses'])->name('users.statuses')->middleware('auth','can:manage-users');

// Public Mall resource
Route::resource('malls', MallController::class);

// Admin area (protected by auth + manage-users gate)
Route::prefix('admin')->middleware(['auth','can:manage-users', 'can:manage-malls','can:view-audits','can:manage-roles'])->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User management
    Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('users/{id}', [UserManagementController::class, 'show'])->name('users.show');
    Route::post('users/{id}/assign-role', [UserManagementController::class, 'assignRole'])->name('users.assign');
    Route::post('users/{id}/revoke-role', [UserManagementController::class, 'revokeRole'])->name('users.revoke');
    Route::post('users/{id}/activate', [UserManagementController::class, 'activate'])->name('users.activate');
    Route::post('users/{id}/deactivate', [UserManagementController::class, 'deactivate'])->name('users.deactivate');
    Route::get('users/{id}/audits', [UserManagementController::class, 'audits'])->name('users.audits');

    // Roles & permissions
    Route::resource('roles', RoleController::class);

    // Admin Mall management
    Route::resource('malls', AdminMallController::class);
});

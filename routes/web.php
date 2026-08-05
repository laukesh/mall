<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\MallController;
use App\Http\Controllers\Admin\UserManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.form');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('throttle:5,1')->name('password.email');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/profile', [AuthController::class, 'profileForm'])->name('profile.form')->middleware('auth');
    Route::get('/dashboard', [AuthController::class, 'dashboardForm'])->name('dashboard.form')->middleware('auth');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password')->middleware('auth');




// Admin UI for user management
Route::prefix('admin')->middleware(['auth','can:manage-users'])->group(function () {
    Route::resource('malls', MallController::class);
    Route::get('users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('users/{id}', [UserManagementController::class, 'show'])->name('admin.users.show');
    Route::post('users/{id}/assign-role', [UserManagementController::class, 'assignRole'])->name('admin.users.assign');
    Route::post('users/{id}/revoke-role', [UserManagementController::class, 'revokeRole'])->name('admin.users.revoke');
    Route::post('users/{id}/activate', [UserManagementController::class, 'activate'])->name('admin.users.activate');
    Route::post('users/{id}/deactivate', [UserManagementController::class, 'deactivate'])->name('admin.users.deactivate');
    Route::get('users/{id}/audits', [UserManagementController::class, 'audits'])->name('admin.users.audits');
});

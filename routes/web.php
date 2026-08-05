<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MallController;

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
Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password')->middleware('auth');

// admin actions
Route::post('/users/{id}/assign-role', [AuthController::class, 'assignRole'])->name('users.assign')->middleware('auth');
Route::post('/users/{id}/revoke-role', [AuthController::class, 'revokeRole'])->name('users.revoke')->middleware('auth');
Route::post('/users/{id}/activate', [AuthController::class, 'activate'])->name('users.activate')->middleware('auth');
Route::post('/users/{id}/deactivate', [AuthController::class, 'deactivate'])->name('users.deactivate')->middleware('auth');
Route::get('/users/statuses', [AuthController::class, 'statuses'])->name('users.statuses')->middleware('auth');

// Mall resource (web)
Route::resource('malls', MallController::class);

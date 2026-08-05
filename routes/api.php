<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Public Routes
Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

});

// Protected Routes
Route::middleware('auth:api')->prefix('auth')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    Route::post('/users/{id}/activate', [AuthController::class, 'activate']);
    Route::post('/users/{id}/deactivate', [AuthController::class, 'deactivate']);

    Route::post('/users/{id}/assign-role', [AuthController::class, 'assignRole']);
    Route::post('/users/{id}/revoke-role', [AuthController::class, 'revokeRole']);

    Route::get('/statuses', [AuthController::class, 'statuses']);
});
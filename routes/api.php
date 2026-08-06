<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\StateController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\PincodeController;

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

// Location API (public read)
Route::prefix('locations')->group(function () {
    Route::get('countries', [CountryController::class, 'index']);
    Route::get('countries/{id}', [CountryController::class, 'show']);

    Route::get('states', [StateController::class, 'index']);
    Route::get('states/{id}', [StateController::class, 'show']);

    Route::get('cities', [CityController::class, 'index']);
    Route::get('cities/{id}', [CityController::class, 'show']);

    Route::get('pincodes', [PincodeController::class, 'index']);
    Route::get('pincodes/{id}', [PincodeController::class, 'show']);
});

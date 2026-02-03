<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\SensorController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (authenticated users)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Device management
    Route::get('/devices', [DeviceController::class, 'index']);
    Route::post('/devices', [DeviceController::class, 'store']);
    Route::get('/devices/{device}', [DeviceController::class, 'show']);
    Route::put('/devices/{device}', [DeviceController::class, 'update']);
    Route::delete('/devices/{device}', [DeviceController::class, 'destroy']);
    Route::get('/devices/{device}/code', [DeviceController::class, 'getCode']);

    // Sensor data and dashboard
    Route::get('/devices/{device}/sensor-data', [SensorController::class, 'getHistory']);
    Route::get('/devices/{device}/sensor-latest', [SensorController::class, 'getLatest']);
    Route::get('/devices/{device}/dashboard', [SensorController::class, 'getDashboardData']);
});

// Sensor data endpoint (from ESP8266, requires API key)
Route::post('/sensor-data', [SensorController::class, 'store']);

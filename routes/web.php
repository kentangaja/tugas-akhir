<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// Mengarahkan halaman utama '/' langsung ke view dashboard tanpa proteksi login
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('/tutorial', function () {
    return view('tutorial');
})->name('tutorial');


Route::middleware(['auth'])->group(function () {
    
    Route::get('/devices', [DeviceController::class, 'index'])
    ->name('devices.index');

    Route::get('/devices/{device}', [DeviceController::class, 'show'])
        ->name('devices.show');

    Route::get('/devices/{device}/code', [DeviceController::class, 'code'])
        ->name('devices.code');

    Route::get('/devices/{device}/latest-data', [DeviceController::class, 'getLatestData'])
        ->name('devices.latest-data');
    
});

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Device create/store require auth
    Route::get('/devices/create', [DeviceController::class, 'create'])
        ->name('devices.create');

    Route::post('/devices', [DeviceController::class, 'store'])
        ->name('devices.store');
});

require __DIR__.'/auth.php';

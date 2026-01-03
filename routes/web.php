<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('devices.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Device routes (IoT UI)
    Route::get('/devices', [DeviceController::class, 'index'])
        ->name('devices.index');

    Route::get('/devices/{device}', [DeviceController::class, 'show'])
        ->name('devices.show');

    Route::get('/devices/{device}/code', [DeviceController::class, 'code'])
        ->name('devices.code');

    Route::get('/devices/create', [DeviceController::class, 'create'])
    ->name('devices.create');

    Route::post('/devices', [DeviceController::class, 'store'])
    ->name('devices.store');
});

require __DIR__.'/auth.php';

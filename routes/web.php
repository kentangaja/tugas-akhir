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

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])
    ->name('contact.store');

Route::get('/team', function () {
    return view('team');
})->name('team');

Route::middleware(['auth'])->group(function () {
    Route::get('/devices', [DeviceController::class, 'index'])
        ->name('devices.index');

    Route::get('/devices/create', [DeviceController::class, 'create'])
        ->name('devices.create');

    Route::post('/devices', [DeviceController::class, 'store'])
        ->name('devices.store');

    Route::get('/devices/{device}', [DeviceController::class, 'show'])
        ->name('devices.show');

    Route::get('/devices/{device}/code', [DeviceController::class, 'code'])
        ->name('devices.code');

    Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])
        ->name('devices.edit');

    Route::patch('/devices/{device}', [DeviceController::class, 'update'])
        ->name('devices.update');

    Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])
        ->name('devices.destroy');

    Route::post('/devices/{device}/toggle-status', [DeviceController::class, 'toggleStatus'])
        ->name('devices.toggle-status');

    Route::get('/devices/{device}/latest-data', [DeviceController::class, 'getLatestData'])
        ->name('devices.latest-data');

    Route::get('/devices/{device}/export-pdf', [DeviceController::class, 'exportPDF'])
        ->name('devices.export-pdf');
        
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    
});


require __DIR__.'/auth.php';

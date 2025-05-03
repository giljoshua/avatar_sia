<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SmartLightController;
use Illuminate\Support\Facades\Route;

// Redirect the root to the smart lights dashboard
Route::get('/', function () {
    return redirect()->route('smart-lights.index');
});

// Redirect the default dashboard to smart lights
Route::get('/dashboard', function () {
    return redirect()->route('smart-lights.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group all authenticated routes
Route::middleware('auth')->group(function () {
    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Smart Light routes (protected by authentication)
    Route::resource('smart-lights', SmartLightController::class);
    Route::put('smart-lights/{smartLight}/toggle', [SmartLightController::class, 'toggleStatus'])->name('smart-lights.toggle');
    Route::get('smart-lights-pdf', [SmartLightController::class, 'generatePDF'])->name('smart-lights.pdf');
    
    // Customer routes (protected by authentication)
    Route::resource('customers', CustomerController::class);
});

// Authentication routes
require __DIR__.'/auth.php';


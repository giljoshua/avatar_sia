<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SmartLightController;

// Make the smart lights dashboard the default homepage
Route::get('/', [SmartLightController::class, 'index']);

// Route for the original customer CRUD
Route::resource('customers', CustomerController::class);

// Routes for smart light management
Route::resource('smart-lights', SmartLightController::class);

// Additional route for toggling light status
Route::put('smart-lights/{smartLight}/toggle', [SmartLightController::class, 'toggleStatus'])->name('smart-lights.toggle');

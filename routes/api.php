<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Employee\EmployeeDashboardController;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

// This matches your Vue: axios.post('/api/login', ...)
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout']);

    // Admin-only Data Routes
    Route::middleware('role:admin')->group(function () {
        // Example: Get data for the admin dashboard cards
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'getStats']);
    });

    // Employee-only Data Routes
    Route::middleware('role:employee')->group(function () {
        // Example: Get data for the POS/Gasman interface
        Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'getInventory']);
    });

});
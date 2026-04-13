<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Employee\EmployeeDashboardController;

// 1. The GET route to show the login form (or serve your Vue SPA)
Route::get('/login', function () {
    return view('login'); // Change this to whatever view loads your Vue app/login page
})->name('login'); // <-- The auth middleware looks for this exact name!

// 2. The POST route that actually processes the login data
Route::post('/login', [AuthController::class, 'login']);
// Changed from 'auth:sanctum' to 'auth' to use Laravel's standard session-based web authentication.
Route::middleware('auth')->group(function () {

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
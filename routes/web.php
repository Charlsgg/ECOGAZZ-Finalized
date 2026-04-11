<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController; // Updated
use App\Http\Controllers\Employee\EmployeeDashboardController; // Updated
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
    });
    
    // Employee Routes
    Route::middleware(['role:employee'])->group(function () {
        Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])
            ->name('employee.dashboard');
    });
    
    /**
     * Generic dashboard redirect
     * This can stay in a "General" controller or the AuthController
     * to decide where to send the user after login.
     */
    Route::get('/dashboard', [AuthController::class, 'redirectByUserRole'])
        ->name('dashboard');
});

// SPA fallback route
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
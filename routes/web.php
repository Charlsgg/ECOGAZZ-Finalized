<?php

use Illuminate\Support\Facades\Route;

/**
 * 1. Public Landing / Login Page
 * This catches the root URL and returns the Vue entry point.
 */
Route::get('/', function () {
    return view('app'); 
});

/**
 * 2. SPA Fallback Route
 * This is CRITICAL. It ensures that when a user refreshes the page 
 * on /admin/dashboard or /employee/dashboard, Laravel sends them 
 * back to the Vue app instead of a 404 error.
 */
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
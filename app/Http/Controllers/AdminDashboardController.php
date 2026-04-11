<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia; // Or use Illuminate\Support\Facades\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        // Initial state for Admin (e.g., total users, system logs, etc.)
        return view('admin.dashboard', [
            'status' => 'Welcome to the Admin Portal',
            'data'   => []
        ]);
    }
}
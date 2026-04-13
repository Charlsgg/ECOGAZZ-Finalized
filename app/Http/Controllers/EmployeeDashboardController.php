<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia; 

class EmployeeDashboardController extends Controller
{
    /**
     * Display the Employee Dashboard.
     */
    public function index()
    {
        // Initial state for Employee (e.g., assigned tasks, shift info)
        return view('employee.dashboard', [
            'status' => 'Welcome to the Employee Portal',
            'data'   => []
        ]);
    }
}
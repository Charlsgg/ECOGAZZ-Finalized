<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Check if user is authenticated (Prevents public access)
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // 2. Check if the user's role matches the required role
        // We normalize to lowercase to prevent "Admin" vs "admin" mismatches
        $userRole = strtolower($request->user()->role);
        $requiredRole = strtolower($role);

        // Handle your specific "Pump Attendant" vs "employee" logic if needed
        if ($requiredRole === 'employee' && $userRole === 'pump attendant') {
            $userRole = 'employee';
        }

        if ($userRole !== $requiredRole) {
            return response()->json([
                'message' => 'Unauthorized. You do not have the required permissions.'
            ], 403);
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Check if user is logged in AND has the correct role
        // This matches the 'role' column in your users table
        if (!$request->user() || strtolower($request->user()->role) !== strtolower($role)) {
            return response()->json(['message' => 'Unauthorized. High-level clearance required.'], 403);
        }

        return $next($request);
    }
}

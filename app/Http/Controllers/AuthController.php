<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // <-- ADDED THIS IMPORT

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'role'     => 'required|string', 
        ]);

        // 1. Find the user by email ONLY first
        $user = User::where('email', $request->email)->first();

        // 2. DEBUG: Check if user exists
        if (!$user) {
            return response()->json(['message' => 'Account with this email not found.'], 401);
        }

        // 3. DEBUG: Check if active
        if (!$user->is_active) {
            return response()->json(['message' => 'This account is currently deactivated.'], 401);
        }

        // 4. DEBUG: Check password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Incorrect password.'], 401);
        }

        /**
         * 5. ROLE NORMALIZATION MAPPING
         */
        $dbRole = $user->role; 
        $sentRole = $request->role; 

        // Group 1: Admin / Manager group
        $isAdminMatch = (
            in_array($sentRole, ['Manager', 'admin', 'Admin']) && 
            in_array($dbRole, ['Manager', 'admin', 'Admin'])
        );

        // Group 2: Staff / Pump Attendant group
        $isStaffMatch = (
            in_array($sentRole, ['Staff', 'employee', 'Employee']) && 
            in_array($dbRole, ['Pump Attendant', 'Staff', 'employee', 'Employee'])
        );

        // Check if either group matches or if they are exactly the same string
        if (!$isAdminMatch && !$isStaffMatch && $sentRole !== $dbRole) {
            return response()->json([
                'message' => "Role mismatch. You tried to log in as $sentRole, but your account is registered as $dbRole.",
            ], 403);
        }

        // 6. LOG THE USER IN VIA SESSION (The crucial fix!)
        Auth::login($user);
        $request->session()->regenerate(); // Protects against session fixation

        // Optional: You can keep generating the Sanctum token if you plan to use Axios for other API calls on the dashboard
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token'  => $token,
            'role'   => $dbRole, 
            'user'   => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        // Destroy the web session
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Destroy the API token (if applicable)
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Logged out successfully']);
    }
}
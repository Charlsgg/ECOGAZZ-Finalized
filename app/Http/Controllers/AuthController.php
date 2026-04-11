<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'role'     => 'required|string', 
        ]);

        // 1. Find the user by email ONLY first (to see if they exist)
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
         * Your DB has "Pump Attendant", but your Vue sends "Staff".
         * We need to allow them to match.
         */
        /**
         * 5. ROLE NORMALIZATION MAPPING
         * Bridges the gap between Frontend Labels and Database Roles
         */
        $dbRole = $user->role; // What is in the Database
        $sentRole = $request->role; // What was clicked in Vue ('Manager' or 'Staff')

        // Group 1: Admin / Manager group
        $isAdminMatch = (
            in_array($sentRole, ['Manager', 'admin']) && 
            in_array($dbRole, ['Manager', 'admin'])
        );

        // Group 2: Staff / Pump Attendant group
        $isStaffMatch = (
            in_array($sentRole, ['Staff', 'employee']) && 
            in_array($dbRole, ['Pump Attendant', 'Staff', 'employee'])
        );

        // Check if either group matches or if they are exactly the same string
        if (!$isAdminMatch && !$isStaffMatch && $sentRole !== $dbRole) {
            return response()->json([
                'message' => "Role mismatch. You tried to log in as $sentRole, but your account is registered as $dbRole.",
            ], 403);
        }

        // 6. Generate Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token'  => $token,
            'role'   => $dbRole, // Send back the real DB role
            'user'   => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
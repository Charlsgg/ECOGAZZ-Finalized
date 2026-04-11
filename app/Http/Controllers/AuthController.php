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
            'pin' => 'required|string',
        ]);

        // 1. Filter only active users from your Model's is_active attribute
        $users = User::where('is_active', true)->get();

        foreach ($users as $user) {
            // 2. Check the hashed password (the PIN)
            if (Hash::check($request->pin, $user->password)) {
                
                // 3. Generate Sanctum token
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'token' => $token,
                    // Map your Model's 'Manager' role to 'admin' for frontend consistency
                    'role' => $user->isManager() ? 'admin' : 'staff',
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                    ]
                ]);
            }
        }

        return response()->json(['message' => 'Invalid PIN or account inactive.'], 401);
    }
}
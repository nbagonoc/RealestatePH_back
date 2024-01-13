<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);

        User::create([
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        $user_id = User::select('id')->where('email', $request->email)->first();

        if ($user_id) {
            Profile::create(['user_id' => $user_id->id]);

            return response()->json('successfully signed-up', 201);
        }

        return response()->json('Failed to sign-up', 500);
    }

    public function signin(Request $request)
    {
        // data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // Authenticate the user
        if (!$token = Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ])) {
            return response()->json("Invalid details", 401);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Define the custom claims for the JWT payload
        $customClaims = [
            'iat' => now()->timestamp,
            'exp' => now()->addHours(24)->timestamp,
            'email' => $user->email,
            'role' => $user->role
        ];

        // Generate JWT token with custom claims
        $token = JWTAuth::claims($customClaims)->fromUser($user);

        return response()->json($token, 200);
    }

    public function logout()
    {
    }
}

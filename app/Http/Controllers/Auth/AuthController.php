<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        // data validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);

        // create user
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        // return response()->json(['message' => 'User created successfully'], 201);
        return response()->json('User created successfully', 201);
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
            'name' => $user->name,
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

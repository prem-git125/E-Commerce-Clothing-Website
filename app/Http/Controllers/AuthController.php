<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'user',
        ]);

        Auth::login($user);

        return response()->json([
            'success' => true, 
            'message' => 'Registration successful.', 
            'data' => $user ], 200
        );
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            return response()->json([
                'success' => true, 
                'message' => 'Login successful.', 
                'data' => Auth::user() ], 200
            );
        } else {
            return response()->json([
                'success' => false, 
                'message' => 'Login failed.', 
                'data' => null ], 401
            );
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'success' => true, 
            'message' => 'Logout successful.', 
            'data' => null ], 200
        );
    }
}

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
            $user = Auth::user();

            return response()->json([
                'success' => true, 
                'message' => 'Login successfully.', 
                'role' => $user->role 
            ], 200);
            
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
        return redirect('/')->with('success', 'Logout successfully.');
    }

    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('auth.login')->with('error', 'You need to login first.');
        }

        return view('pages.profile.index', compact('user'));
    }

    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if(!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated.'], 401);
        }

        if ($request->hasFile('profile_url')) {
            $file = $request->file('profile_url');
            $path = $file->store('profile_images', 'public');

            // Update user's profile_url
            $user->profile_url = $path;
            $user->save();

            return response()->json([
                'success' => true, 
                'message' => 'Profile image updated successfully.', 
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'No file uploaded.'], 400);
        }
    }
}

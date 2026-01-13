<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService {
    public function register(array $credentials) {
        $user = User::create([
            'first_name' => $credentials['first_name'],
            'last_name' => $credentials['last_name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Registered Successfully",
            'data' => $user
        ], 201);
    }

    public function login(array $credentials) {

        $user = User::where('email', $credentials['email'])->first();

        if (!Auth::attempt($credentials)){
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials do not match our records.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully Logged In'
        ]);
    }

}

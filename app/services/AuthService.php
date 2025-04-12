<?php
// app/Services/AuthService.php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data): User
    {
        return User::create([
            'id' => $data['id'] ?? \Illuminate\Support\Str::uuid(),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'is_active' => true
        ]);
    }

    public function login(array $credentials): ?string
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            return null;
        }
        return $token;
    }

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refreshToken(): string
    {
        return JWTAuth::refresh(JWTAuth::getToken());
    }

    public function getAuthenticatedUser(): User
    {
        return JWTAuth::parseToken()->authenticate();
    }
}
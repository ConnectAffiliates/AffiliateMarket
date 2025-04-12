<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\Exceptions\UserNotFoundException;

class AuthService implements AuthServiceInterface
{
    public function register(array $data): User
    {
        $user = User::create([
            'id' => $data['id'] ?? \Illuminate\Support\Str::uuid(),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'is_active' => true
        ]);

        // Assign default role if not provided
        $role = $data['role'] ?? 'affiliate';
        $user->assignRole($role);

        return $user;
    }

    public function login(array $credentials): array
    {
        if (!$token = Auth::attempt($credentials)) {
            throw new \Exception('Invalid credentials', 401);
        }

        $user = Auth::user();
        if (!$user->is_active) {
            throw new \Exception('Account is inactive', 403);
        }

        return $this->respondWithToken($token);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function refreshToken(): array
    {
        return $this->respondWithToken(Auth::refresh());
    }

    public function getAuthenticatedUser(): User
    {
        return Auth::user();
    }

    protected function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => Auth::user()
        ];
    }
}
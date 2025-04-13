<?php

namespace App\Services\Contracts;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data): User;
    public function login(array $credentials): array;
    public function logout(): void;
    public function refreshToken(): array;
    public function getAuthenticatedUser(): User;
}
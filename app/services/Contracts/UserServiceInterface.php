<?php

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

interface UserServiceInterface
{
    public function getAllUsers(array $filters = []): Paginator;
    public function getUserById(string $id): User;
    public function createUser(array $data): User;
    public function updateUser(string $id, array $data): User;
    public function deleteUser(string $id): void;
    public function assignRole(string $userId, string $role): void;
    public function removeRole(string $userId, string $role): void;
    public function givePermission(string $userId, string $permission): void;
    public function revokePermission(string $userId, string $permission): void;
}
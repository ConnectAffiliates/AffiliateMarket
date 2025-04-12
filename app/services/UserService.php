<?php
// app/Services/UserService.php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function paginateUsers(int $perPage = 15): LengthAwarePaginator
    {
        return User::query()->paginate($perPage);
    }

    public function getUserById(string $id): User
    {
        return User::findOrFail($id);
    }

    public function updateUser(User $user, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $user->fresh();
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    public function activateUser(User $user): User
    {
        $user->update(['is_active' => true]);
        return $user->fresh();
    }

    public function deactivateUser(User $user): User
    {
        $user->update(['is_active' => false]);
        return $user->fresh();
    }
}
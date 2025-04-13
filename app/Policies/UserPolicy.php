<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view-users');
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasPermission('view-users') || 
               $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('create-users');
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasPermission('update-users') || 
               $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasPermission('delete-users') && 
               $user->id !== $model->id;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->hasPermission('restore-users');
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasPermission('force-delete-users');
    }
}
<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use App\Services\Exceptions\UserNotFoundException;
use App\Services\Exceptions\RoleNotFoundException;
use App\Services\Exceptions\PermissionNotFoundException;

class UserService implements UserServiceInterface
{
    public function getAllUsers(array $filters = []): Paginator
    {
        return User::query()
            ->when(isset($filters['role']), function ($query) use ($filters) {
                $query->whereHas('roles', function ($q) use ($filters) {
                    $q->where('name', $filters['role']);
                });
            })
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->where('email', 'like', "%{$filters['search']}%")
                      ->orWhere('first_name', 'like', "%{$filters['search']}%")
                      ->orWhere('last_name', 'like', "%{$filters['search']}%");
                });
            })
            ->paginate($filters['per_page'] ?? 15);
    }

    public function getUserById(string $id): User
    {
        $user = User::find($id);
        if (!$user) {
            throw new UserNotFoundException();
        }
        return $user->load('roles', 'permissions');
    }

    public function createUser(array $data): User
    {
        $user = User::create([
            'id' => $data['id'] ?? \Illuminate\Support\Str::uuid(),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'is_active' => $data['is_active'] ?? true
        ]);

        if (isset($data['roles'])) {
            foreach ($data['roles'] as $role) {
                $this->assignRole($user->id, $role);
            }
        }

        return $user->load('roles', 'permissions');
    }

    public function updateUser(string $id, array $data): User
    {
        $user = $this->getUserById($id);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
        }

        if (isset($data['permissions'])) {
            $user->permissions()->sync($data['permissions']);
        }

        return $user->refresh()->load('roles', 'permissions');
    }

    public function deleteUser(string $id): void
    {
        $user = $this->getUserById($id);
        $user->delete();
    }

    public function assignRole(string $userId, string $role): void
    {
        $user = $this->getUserById($userId);
        $roleModel = Role::where('name', $role)->first();

        if (!$roleModel) {
            throw new RoleNotFoundException();
        }

        $user->assignRole($roleModel);
    }

    public function removeRole(string $userId, string $role): void
    {
        $user = $this->getUserById($userId);
        $roleModel = Role::where('name', $role)->first();

        if (!$roleModel) {
            throw new RoleNotFoundException();
        }

        $user->removeRole($roleModel);
    }

    public function givePermission(string $userId, string $permission): void
    {
        $user = $this->getUserById($userId);
        $permissionModel = Permission::where('name', $permission)->first();

        if (!$permissionModel) {
            throw new PermissionNotFoundException();
        }

        $user->givePermissionTo($permissionModel);
    }

    public function revokePermission(string $userId, string $permission): void
    {
        $user = $this->getUserById($userId);
        $permissionModel = Permission::where('name', $permission)->first();

        if (!$permissionModel) {
            throw new PermissionNotFoundException();
        }

        $user->revokePermissionTo($permissionModel);
    }
}
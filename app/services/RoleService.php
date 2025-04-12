<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;
use App\Services\Contracts\RoleServiceInterface;
use Illuminate\Support\Collection;
use App\Services\Exceptions\RoleNotFoundException;
use App\Services\Exceptions\PermissionNotFoundException;

class RoleService implements RoleServiceInterface
{
    public function getAllRoles(): Collection
    {
        return Role::with('permissions')->get();
    }

    public function getRoleByName(string $name): Role
    {
        $role = Role::where('name', $name)->with('permissions')->first();
        if (!$role) {
            throw new RoleNotFoundException();
        }
        return $role;
    }

    public function createRole(array $data): Role
    {
        return Role::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null
        ]);
    }

    public function updateRole(string $id, array $data): Role
    {
        $role = Role::find($id);
        if (!$role) {
            throw new RoleNotFoundException();
        }

        $role->update($data);
        return $role->refresh();
    }

    public function deleteRole(string $id): void
    {
        $role = Role::find($id);
        if (!$role) {
            throw new RoleNotFoundException();
        }

        $role->delete();
    }

    public function assignPermission(string $roleId, string $permission): void
    {
        $role = Role::find($roleId);
        if (!$role) {
            throw new RoleNotFoundException();
        }

        $permissionModel = Permission::where('name', $permission)->first();
        if (!$permissionModel) {
            throw new PermissionNotFoundException();
        }

        $role->givePermissionTo($permissionModel);
    }

    public function revokePermission(string $roleId, string $permission): void
    {
        $role = Role::find($roleId);
        if (!$role) {
            throw new RoleNotFoundException();
        }

        $permissionModel = Permission::where('name', $permission)->first();
        if (!$permissionModel) {
            throw new PermissionNotFoundException();
        }

        $role->permissions()->detach($permissionModel->id);
    }
}
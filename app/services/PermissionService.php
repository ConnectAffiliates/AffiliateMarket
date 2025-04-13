<?php

namespace App\Services;

use App\Models\Permission;
use App\Services\Contracts\PermissionServiceInterface;
use Illuminate\Support\Collection;
use App\Services\Exceptions\PermissionNotFoundException;

class PermissionService implements PermissionServiceInterface
{
    public function getAllPermissions(): Collection
    {
        return Permission::all();
    }

    public function getPermissionByName(string $name): Permission
    {
        $permission = Permission::where('name', $name)->first();
        if (!$permission) {
            throw new PermissionNotFoundException();
        }
        return $permission;
    }

    public function createPermission(array $data): Permission
    {
        return Permission::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null
        ]);
    }

    public function updatePermission(string $id, array $data): Permission
    {
        $permission = Permission::find($id);
        if (!$permission) {
            throw new PermissionNotFoundException();
        }

        $permission->update($data);
        return $permission->refresh();
    }

    public function deletePermission(string $id): void
    {
        $permission = Permission::find($id);
        if (!$permission) {
            throw new PermissionNotFoundException();
        }

        $permission->delete();
    }
}
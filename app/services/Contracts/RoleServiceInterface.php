<?php

namespace App\Services\Contracts;

use App\Models\Role;
use Illuminate\Support\Collection;

interface RoleServiceInterface
{
    public function getAllRoles(): Collection;
    public function getRoleByName(string $name): Role;
    public function createRole(array $data): Role;
    public function updateRole(string $id, array $data): Role;
    public function deleteRole(string $id): void;
    public function assignPermission(string $roleId, string $permission): void;
    public function revokePermission(string $roleId, string $permission): void;
}
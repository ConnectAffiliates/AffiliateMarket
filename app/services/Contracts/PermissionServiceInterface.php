<?php

namespace App\Services\Contracts;

use App\Models\Permission;
use Illuminate\Support\Collection;

interface PermissionServiceInterface
{
    public function getAllPermissions(): Collection;
    public function getPermissionByName(string $name): Permission;
    public function createPermission(array $data): Permission;
    public function updatePermission(string $id, array $data): Permission;
    public function deletePermission(string $id): void;
}
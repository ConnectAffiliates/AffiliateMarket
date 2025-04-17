<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Permission\Contracts\Role as RoleContract;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model implements RoleContract
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'description', 'guard_name'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
            if (!$model->guard_name) {
                $model->guard_name = 'web';
            }
        });
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id')
            ->where('model_type', User::class);
    }

    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->firstOrFail();
        }
        $this->permissions()->syncWithoutDetaching($permission);
    }

    public static function findByName(string $name, ?string $guardName = null): RoleContract
    {
        return static::where('name', $name)
            ->where('guard_name', $guardName ?? 'web')
            ->firstOrFail();
    }

    public static function findById(int|string $id, ?string $guardName = null): RoleContract
    {
        return static::where('id', $id)
            ->where('guard_name', $guardName ?? 'web')
            ->firstOrFail();
    }

    public static function findOrCreate(string $name, ?string $guardName = null): RoleContract
    {
        $role = static::where('name', $name)
            ->where('guard_name', $guardName ?? 'web')
            ->first();

        if (!$role) {
            $role = static::create([
                'name' => $name,
                'guard_name' => $guardName ?? 'web'
            ]);
        }

        return $role;
    }

    public function hasPermissionTo($permission, ?string $guardName = null): bool
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)
                ->where('guard_name', $guardName ?? 'web')
                ->first();
        }
        return $permission ? $this->permissions->contains($permission) : false;
    }
}
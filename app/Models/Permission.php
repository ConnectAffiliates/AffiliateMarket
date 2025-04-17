<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Permission\Contracts\Permission as PermissionContract;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model implements PermissionContract
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_permissions', 'permission_id', 'model_id')
            ->where('model_type', User::class);
    }

    public static function findByName(string $name, ?string $guardName = null): PermissionContract
    {
        return static::where('name', $name)
            ->where('guard_name', $guardName ?? 'web')
            ->firstOrFail();
    }

    public static function findById(int|string $id, ?string $guardName = null): PermissionContract
    {
        return static::where('id', $id)
            ->where('guard_name', $guardName ?? 'web')
            ->firstOrFail();
    }

    public static function findOrCreate(string $name, ?string $guardName = null): PermissionContract
    {
        $permission = static::where('name', $name)
            ->where('guard_name', $guardName ?? 'web')
            ->first();

        if (!$permission) {
            $permission = static::create([
                'name' => $name,
                'guard_name' => $guardName ?? 'web'
            ]);
        }

        return $permission;
    }
}
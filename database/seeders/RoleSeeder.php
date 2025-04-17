<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'view campaigns',
            'create campaigns',
            'edit campaigns',
            'delete campaigns',
            'view affiliates',
            'manage affiliates',
            'view payments',
            'manage payments',
            'view analytics',
            'manage settings'
        ];

        $permissionObjects = [];
        foreach ($permissions as $permission) {
            $permissionObjects[$permission] = Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['description' => ucfirst($permission)]
            );
        }

        // Create roles
        $advertiserRole = Role::firstOrCreate(
            ['name' => 'advertiser', 'guard_name' => 'web'],
            ['description' => 'Advertiser User']
        );
        
        $affiliateRole = Role::firstOrCreate(
            ['name' => 'affiliate', 'guard_name' => 'web'],
            ['description' => 'Affiliate Marketer']
        );
        
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web'],
            ['description' => 'Administrator']
        );

        // Assign permissions to roles
        $advertiserRole->permissions()->syncWithoutDetaching([
            $permissionObjects['view campaigns']->id,
            $permissionObjects['create campaigns']->id,
            $permissionObjects['edit campaigns']->id,
            $permissionObjects['delete campaigns']->id,
            $permissionObjects['view affiliates']->id,
            $permissionObjects['view payments']->id,
            $permissionObjects['view analytics']->id,
            $permissionObjects['manage settings']->id
        ]);

        $affiliateRole->permissions()->syncWithoutDetaching([
            $permissionObjects['view campaigns']->id,
            $permissionObjects['view payments']->id,
            $permissionObjects['view analytics']->id,
            $permissionObjects['manage settings']->id
        ]);

        $adminRole->permissions()->syncWithoutDetaching(
            collect($permissionObjects)->pluck('id')->toArray()
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // User permissions
            ['name' => 'view-users', 'description' => 'View users'],
            ['name' => 'create-users', 'description' => 'Create users'],
            ['name' => 'update-users', 'description' => 'Update users'],
            ['name' => 'delete-users', 'description' => 'Delete users'],
            
            // Campaign permissions
            ['name' => 'view-campaigns', 'description' => 'View campaigns'],
            ['name' => 'create-campaigns', 'description' => 'Create campaigns'],
            ['name' => 'update-campaigns', 'description' => 'Update campaigns'],
            ['name' => 'delete-campaigns', 'description' => 'Delete campaigns'],
            
            // Performance permissions
            ['name' => 'view-performance', 'description' => 'View performance metrics'],
            ['name' => 'export-performance', 'description' => 'Export performance data'],
            
            // Admin permissions
            ['name' => 'manage-roles', 'description' => 'Manage roles and permissions'],
            ['name' => 'manage-system', 'description' => 'Manage system settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Assign permissions to roles
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo(Permission::all());

        $advertiserRole = Role::where('name', 'advertiser')->first();
        $advertiserRole->givePermissionTo([
            'view-campaigns',
            'create-campaigns',
            'update-campaigns',
            'view-performance'
        ]);

        $affiliateRole = Role::where('name', 'affiliate')->first();
        $affiliateRole->givePermissionTo([
            'view-campaigns',
            'view-performance'
        ]);
    }
}
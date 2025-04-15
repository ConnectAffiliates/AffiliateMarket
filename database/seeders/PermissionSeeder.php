<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Advertiser permissions
            ['name' => 'create-campaign', 'description' => 'Create advertising campaign'],
            ['name' => 'edit-campaign', 'description' => 'Edit advertising campaign'],
            ['name' => 'delete-campaign', 'description' => 'Delete advertising campaign'],
            ['name' => 'view-campaign-stats', 'description' => 'View campaign statistics'],

            // Affiliate permissions
            ['name' => 'view-campaigns', 'description' => 'View available campaigns'],
            ['name' => 'generate-affiliate-link', 'description' => 'Generate affiliate links'],
            ['name' => 'view-earnings', 'description' => 'View earnings and statistics'],
            ['name' => 'withdraw-earnings', 'description' => 'Withdraw earned commissions'],

            // Admin permissions
            ['name' => 'manage-users', 'description' => 'Manage user accounts'],
            ['name' => 'manage-roles', 'description' => 'Manage user roles'],
            ['name' => 'manage-permissions', 'description' => 'Manage permissions'],
            ['name' => 'view-platform-stats', 'description' => 'View platform statistics'],

            // Moderator permissions
            ['name' => 'review-campaigns', 'description' => 'Review advertising campaigns'],
            ['name' => 'moderate-content', 'description' => 'Moderate platform content'],
            ['name' => 'manage-reports', 'description' => 'Handle user reports'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}

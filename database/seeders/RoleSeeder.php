<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator'],
            ['name' => 'advertiser', 'description' => 'Advertiser User'],
            ['name' => 'affiliate', 'description' => 'Affiliate Marketer'],
            ['name' => 'moderator', 'description' => 'Content Moderator'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

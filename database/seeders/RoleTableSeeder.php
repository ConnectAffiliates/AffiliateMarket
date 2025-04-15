<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    public function run()
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
<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        // Create test advertiser
        $advertiser = User::firstOrCreate(
            ['email' => 'advertiser@test.com'],
            [
                'id' => (string) Str::uuid(),
                'first_name' => 'Test',
                'last_name' => 'Advertiser',
                'password' => bcrypt('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $advertiser->assignRole('advertiser');

        // Create test affiliate
        $affiliate = User::firstOrCreate(
            ['email' => 'affiliate@test.com'],
            [
                'id' => (string) Str::uuid(),
                'first_name' => 'Test',
                'last_name' => 'Affiliate',
                'password' => bcrypt('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $affiliate->assignRole('affiliate');

        // Create test admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'id' => (string) Str::uuid(),
                'first_name' => 'Test',
                'last_name' => 'Admin',
                'password' => bcrypt('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');
    }
} 
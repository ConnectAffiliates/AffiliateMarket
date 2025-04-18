<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get advertisers
        $advertisers = User::role('advertiser')->get();
        if ($advertisers->isEmpty()) {
            $this->command->warn('No advertisers found. Make sure to run the UserSeeder first.');
            return;
        }

        $campaignTypes = ['online', 'physical', 'hybrid'];
        $statuses = ['active', 'paused', 'completed', 'cancelled'];
        $commissionTypes = ['percentage', 'fixed', 'hybrid'];

        // Create 5 sample campaigns
        for ($i = 0; $i < 5; $i++) {
            $advertiser = $advertisers->random();
            $commissionType = $commissionTypes[array_rand($commissionTypes)];
            $commissionPercentage = $commissionType === 'percentage' || $commissionType === 'hybrid' ? rand(5, 20) : 0;
            $commissionFixed = $commissionType === 'fixed' || $commissionType === 'hybrid' ? rand(2000, 10000) : 0;
            
            Campaign::create([
                'user_id' => $advertiser->id,
                'name' => fake()->words(3, true) . ' Campaign',
                'description' => fake()->paragraph(),
                'campaign_type' => $campaignTypes[array_rand($campaignTypes)],
                'target_url' => fake()->url(),
                'physical_address' => fake()->address(),
                'phone_number' => fake()->phoneNumber(),
                'social_media_links' => json_encode([
                    'facebook' => 'https://facebook.com/' . fake()->userName(),
                    'instagram' => 'https://instagram.com/' . fake()->userName(),
                ]),
                'budget' => rand(500000, 5000000),
                'cost_per_click' => rand(500, 2000),
                'cost_per_action' => rand(5000, 15000),
                'commission_percentage' => $commissionPercentage,
                'commission_fixed' => $commissionFixed,
                'commission_type' => $commissionType,
                'start_date' => now(),
                'end_date' => now()->addMonths(rand(1, 6)),
                'status' => $i < 3 ? 'active' : $statuses[array_rand($statuses)],
            ]);
        }
        
        $this->command->info('Sample campaigns created successfully!');
    }
} 
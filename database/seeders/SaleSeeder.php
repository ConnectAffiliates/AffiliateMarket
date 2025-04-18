<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get advertisers and affiliates
        $advertisers = User::role('advertiser')->get();
        if ($advertisers->isEmpty()) {
            $this->command->warn('No advertisers found. Make sure to run the UserSeeder first.');
            return;
        }

        $affiliates = User::role('affiliate')->get();
        if ($affiliates->isEmpty()) {
            $this->command->warn('No affiliates found. Make sure to run the UserSeeder first.');
            return;
        }

        // Get campaigns
        $campaigns = Campaign::all();
        if ($campaigns->isEmpty()) {
            $this->command->warn('No campaigns found. Make sure to run the CampaignSeeder first.');
            return;
        }

        $statuses = ['pending', 'approved', 'rejected', 'flagged'];
        
        // Create 15 sample sales
        for ($i = 0; $i < 15; $i++) {
            $campaign = $campaigns->random();
            $affiliate = $affiliates->random();
            $advertiser = $campaign->advertiser_id ? User::find($campaign->advertiser_id) : $advertisers->random();
            
            $amount = rand(5000, 200000);
            $commission = $amount * 0.1; // 10% commission
            
            Sale::create([
                'id' => Str::uuid(),
                'campaign_id' => $campaign->id,
                'referral_id' => strtoupper(Str::random(8)),
                'affiliate_id' => $affiliate->id,
                'advertiser_id' => $advertiser->id,
                'customer_name' => fake()->name(),
                'customer_email' => fake()->safeEmail(),
                'amount' => $amount,
                'commission' => $commission,
                'status' => $statuses[array_rand($statuses)],
                'order_id' => 'ORD-' . strtoupper(Str::random(8)),
                'ip_address' => fake()->ipv4(),
                'notes' => rand(0, 1) ? fake()->sentence() : null,
            ]);
        }
        
        $this->command->info('Sample sales data created successfully!');
    }
} 
<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AffiliateService
{
    public function getTopAffiliatesForAdvertiser($advertiserId, $limit = 5)
    {
        // Mock data for now
        return collect([
            [
                'id' => 1,
                'name' => 'Sarah Johnson',
                'conversions' => 87,
                'earnings' => 'TZS 2,175,000',
                'conversion_rate' => '8.2%'
            ],
            [
                'id' => 2,
                'name' => 'Tech Review Blog',
                'conversions' => 64,
                'earnings' => 'TZS 1,600,000',
                'conversion_rate' => '7.5%'
            ],
            [
                'id' => 3,
                'name' => 'Fitness Influencer',
                'conversions' => 45,
                'earnings' => 'TZS 1,125,000',
                'conversion_rate' => '9.1%'
            ]
        ]);
    }
} 
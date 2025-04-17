<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CampaignController extends Controller
{
    public function index()
    {
        return Inertia::render('Advertiser/Campaigns');
    }

    public function create()
    {
        return Inertia::render('Advertiser/CampaignCreate');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'campaign_type' => 'required|string|in:physical,online,hybrid',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric|min:0',
            'commission_type' => 'required|string|in:fixed,percentage,tiered',
            'commission_value' => 'required|string',
            'verification_method' => 'required|string|in:code,qr,sms,link',
            'terms_conditions' => 'nullable|string',
            'store_address' => 'nullable|string|required_if:campaign_type,physical,hybrid',
            'website_url' => 'nullable|url|required_if:campaign_type,online,hybrid',
            'product_categories' => 'nullable|array',
            'target_audience' => 'nullable|array',
        ]);

        // TODO: Store the campaign in the database
        // For now, just redirect back to the campaigns page with a success message
        
        return redirect()->route('advertiser.campaigns')->with('success', 'Campaign created successfully');
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('user_id', auth()->id())
            ->with(['clicks', 'conversions'])
            ->get()
            ->map(function ($campaign) {
                return [
                    'id' => $campaign->id,
                    'name' => $campaign->name,
                    'clicks' => $campaign->clicks->count(),
                    'conversions' => $campaign->conversions->count(),
                    'earnings' => $campaign->clicks->sum('cost') + $campaign->conversions->sum('cost'),
                    'status' => $campaign->status,
                ];
            });

        return Inertia::render('Advertiser/Campaigns', [
            'campaigns' => $campaigns
        ]);
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
            'target_url' => 'required|url',
            'budget' => 'required|numeric|min:0',
            'cost_per_click' => 'required|numeric|min:0',
            'cost_per_action' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $campaign = Campaign::create([
            ...$validated,
            'user_id' => auth()->id(),
            'status' => 'active',
        ]);

        return redirect()->route('advertiser.campaigns')
            ->with('success', 'Campaign created successfully.');
    }

    public function show(Campaign $campaign)
    {
        return Inertia::render('Advertiser/CampaignDetail', [
            'campaign' => $campaign->load(['clicks', 'conversions'])
        ]);
    }
}

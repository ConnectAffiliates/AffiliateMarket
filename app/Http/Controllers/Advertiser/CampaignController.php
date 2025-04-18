<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Services\CampaignService;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function index()
    {
        $campaigns = $this->campaignService->getAllCampaigns();
        
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:1',
            'commission_type' => 'required|string|in:fixed,percentage',
            'commission_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'terms' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'target_audience' => 'nullable|string',
            'allowed_promotion_methods' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $campaign = $this->campaignService->createCampaign($request->all());

        return redirect()->route('advertiser.campaigns')->with('success', 'Campaign created successfully!');
    }

    public function show($id)
    {
        $campaign = $this->campaignService->getCampaignById($id);
        
        return Inertia::render('Advertiser/CampaignDetail', [
            'campaign' => $campaign
        ]);
    }

    public function edit($id)
    {
        $campaign = $this->campaignService->getCampaignById($id);
        
        return Inertia::render('Advertiser/CampaignEdit', [
            'campaign' => $campaign
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:1',
            'commission_type' => 'required|string|in:fixed,percentage',
            'commission_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'terms' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'target_audience' => 'nullable|string',
            'allowed_promotion_methods' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $campaign = $this->campaignService->updateCampaign($id, $request->all());

        return redirect()->route('advertiser.campaigns')->with('success', 'Campaign updated successfully!');
    }

    public function destroy($id)
    {
        $this->campaignService->deleteCampaign($id);
        
        return redirect()->route('advertiser.campaigns')->with('success', 'Campaign deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $campaign = $this->campaignService->toggleCampaignStatus($id);
        
        $status = $campaign->status === 'active' ? 'activated' : 'paused';
        
        return redirect()->back()->with('success', "Campaign {$status} successfully!");
    }
} 
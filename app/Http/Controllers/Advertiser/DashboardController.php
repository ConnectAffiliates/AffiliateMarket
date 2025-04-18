<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\CampaignService;
use App\Services\SaleService;
use App\Services\AffiliateService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $campaignService;
    protected $saleService;
    protected $affiliateService;

    public function __construct(
        CampaignService $campaignService,
        SaleService $saleService = null,
        AffiliateService $affiliateService = null
    ) {
        $this->campaignService = $campaignService;
        $this->saleService = $saleService;
        $this->affiliateService = $affiliateService;
    }

    public function index()
    {
        $user = Auth::user();

        // Get campaign stats
        $campaignStats = $this->campaignService->getCampaignStats();
        
        // Get performance stats
        $performanceStats = $this->campaignService->getPerformanceStats();
        
        // Get active campaigns
        $activeCampaigns = $this->campaignService->getActiveCampaigns();
        
        // Get top affiliates and recent sales if services are available
        $topAffiliates = $this->affiliateService ? $this->affiliateService->getTopAffiliatesForAdvertiser($user->id) : [];
        $recentSales = $this->saleService ? $this->saleService->getRecentSalesForAdvertiser($user->id, 5) : [];

        return Inertia::render('Advertiser/Dashboard', [
            'stats' => [
                'campaigns' => $campaignStats,
                'performance' => $performanceStats,
            ],
            'activeCampaigns' => $activeCampaigns,
            'topAffiliates' => $topAffiliates,
            'recentSales' => $recentSales,
        ]);
    }
} 
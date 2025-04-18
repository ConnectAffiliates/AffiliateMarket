<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerifySalesController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index()
    {
        $sales = $this->saleService->getAllSales();
        
        return Inertia::render('Advertiser/VerifySales', [
            'sales' => $sales
        ]);
    }

    public function approve($id)
    {
        $this->saleService->updateSaleStatus($id, 'approved');
        
        return redirect()->back()->with('success', 'Sale approved successfully!');
    }

    public function reject($id)
    {
        $this->saleService->updateSaleStatus($id, 'rejected');
        
        return redirect()->back()->with('success', 'Sale rejected successfully!');
    }

    public function flag($id)
    {
        $this->saleService->updateSaleStatus($id, 'flagged');
        
        return redirect()->back()->with('success', 'Sale flagged for review!');
    }
} 
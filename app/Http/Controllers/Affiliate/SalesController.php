<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index()
    {
        $sales = $this->saleService->getAllSales();
        $stats = $this->saleService->getSalesStats();
        
        return Inertia::render('Affiliate/Sales', [
            'sales' => $sales,
            'stats' => $stats
        ]);
    }
}

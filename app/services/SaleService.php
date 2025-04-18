<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class SaleService
{
    public function getAllSales($user = null)
    {
        $user = $user ?? Auth::user();
        
        if ($user->hasRole('admin')) {
            return Sale::with(['campaign', 'affiliate', 'advertiser'])->latest()->get();
        } elseif ($user->hasRole('advertiser')) {
            return Sale::with(['campaign', 'affiliate'])
                ->where('advertiser_id', $user->id)
                ->latest()
                ->get();
        } elseif ($user->hasRole('affiliate')) {
            return Sale::with(['campaign', 'advertiser'])
                ->where('affiliate_id', $user->id)
                ->latest()
                ->get();
        }
        
        return collect();
    }

    public function getSalesByStatus($status, $user = null)
    {
        $user = $user ?? Auth::user();
        
        if ($user->hasRole('admin')) {
            return Sale::with(['campaign', 'affiliate', 'advertiser'])
                ->where('status', $status)
                ->latest()
                ->get();
        } elseif ($user->hasRole('advertiser')) {
            return Sale::with(['campaign', 'affiliate'])
                ->where('advertiser_id', $user->id)
                ->where('status', $status)
                ->latest()
                ->get();
        } elseif ($user->hasRole('affiliate')) {
            return Sale::with(['campaign', 'advertiser'])
                ->where('affiliate_id', $user->id)
                ->where('status', $status)
                ->latest()
                ->get();
        }
        
        return collect();
    }

    public function getSaleById($id, $user = null)
    {
        $user = $user ?? Auth::user();
        
        if ($user->hasRole('admin')) {
            return Sale::with(['campaign', 'affiliate', 'advertiser'])->findOrFail($id);
        } elseif ($user->hasRole('advertiser')) {
            return Sale::with(['campaign', 'affiliate'])
                ->where('advertiser_id', $user->id)
                ->where('id', $id)
                ->firstOrFail();
        } elseif ($user->hasRole('affiliate')) {
            return Sale::with(['campaign', 'advertiser'])
                ->where('affiliate_id', $user->id)
                ->where('id', $id)
                ->firstOrFail();
        }
        
        abort(403, 'Unauthorized action.');
    }

    public function createSale(array $data)
    {
        return Sale::create($data);
    }

    public function updateSale($id, array $data, $user = null)
    {
        $user = $user ?? Auth::user();
        $sale = $this->getSaleById($id, $user);
        
        $sale->update($data);
        
        return $sale;
    }

    public function updateSaleStatus($id, $status, $user = null)
    {
        $user = $user ?? Auth::user();
        $sale = $this->getSaleById($id, $user);
        
        $sale->status = $status;
        $sale->save();
        
        return $sale;
    }

    public function getRecentSalesForAdvertiser($advertiserId, $limit = 10)
    {
        return Sale::with(['campaign', 'affiliate'])
            ->where('advertiser_id', $advertiserId)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getRecentSalesForAffiliate($affiliateId, $limit = 10)
    {
        return Sale::with(['campaign', 'advertiser'])
            ->where('affiliate_id', $affiliateId)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getSalesStats($user = null)
    {
        $user = $user ?? Auth::user();
        
        $sales = $this->getAllSales($user);
        
        $totalAmount = $sales->sum('amount');
        $totalCommission = $sales->sum('commission');
        
        $stats = [
            'total' => $sales->count(),
            'pending' => $sales->where('status', 'pending')->count(),
            'approved' => $sales->where('status', 'approved')->count(),
            'rejected' => $sales->where('status', 'rejected')->count(),
            'totalAmount' => $totalAmount,
            'totalCommission' => $totalCommission,
        ];
        
        return $stats;
    }
} 
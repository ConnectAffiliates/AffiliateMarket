<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CampaignService
{
    public function getAllCampaigns($user = null)
    {
        $user = $user ?? Auth::user();
        
        if ($user->hasRole('admin')) {
            return Campaign::with(['advertiser'])->latest()->get();
        } else {
            return Campaign::where('user_id', $user->id)->latest()->get();
        }
    }

    public function getActiveCampaigns($user = null)
    {
        $user = $user ?? Auth::user();
        
        if ($user->hasRole('admin')) {
            return Campaign::with(['advertiser'])->where('status', 'active')->latest()->get();
        } else {
            return Campaign::where('user_id', $user->id)
                ->where('status', 'active')
                ->latest()
                ->get();
        }
    }

    public function getCampaignsByStatus($status, $user = null)
    {
        $user = $user ?? Auth::user();
        
        if ($user->hasRole('admin')) {
            return Campaign::with(['advertiser'])->where('status', $status)->latest()->get();
        } else {
            return Campaign::where('user_id', $user->id)
                ->where('status', $status)
                ->latest()
                ->get();
        }
    }

    public function getCampaignById($id, $user = null)
    {
        $user = $user ?? Auth::user();
        
        if ($user->hasRole('admin')) {
            return Campaign::with(['advertiser'])->findOrFail($id);
        } else {
            return Campaign::where('user_id', $user->id)
                ->where('id', $id)
                ->firstOrFail();
        }
    }

    public function createCampaign(array $data, $user = null)
    {
        $user = $user ?? Auth::user();
        
        $data['user_id'] = $user->id;
        $data['id'] = Str::uuid();
        
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->uploadImage($data['image']);
        }
        
        return Campaign::create($data);
    }

    public function updateCampaign($id, array $data, $user = null)
    {
        $user = $user ?? Auth::user();
        $campaign = $this->getCampaignById($id, $user);
        
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Delete old image if it exists
            if ($campaign->image && Storage::exists($campaign->image)) {
                Storage::delete($campaign->image);
            }
            
            $data['image'] = $this->uploadImage($data['image']);
        }
        
        $campaign->update($data);
        
        return $campaign;
    }

    public function deleteCampaign($id, $user = null)
    {
        $user = $user ?? Auth::user();
        $campaign = $this->getCampaignById($id, $user);
        
        // Delete image if it exists
        if ($campaign->image && Storage::exists($campaign->image)) {
            Storage::delete($campaign->image);
        }
        
        return $campaign->delete();
    }

    public function toggleCampaignStatus($id, $user = null)
    {
        $user = $user ?? Auth::user();
        $campaign = $this->getCampaignById($id, $user);
        
        $newStatus = $campaign->status === 'active' ? 'paused' : 'active';
        $campaign->status = $newStatus;
        $campaign->save();
        
        return $campaign;
    }

    private function uploadImage(UploadedFile $file)
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/img/campaigns', $filename);
        return str_replace('public', '/storage', $path);
    }

    public function getCampaignStats($user = null)
    {
        $user = $user ?? Auth::user();
        
        $stats = [
            'total' => 0,
            'active' => 0,
            'paused' => 0,
            'draft' => 0,
            'completed' => 0
        ];
        
        $campaigns = $this->getAllCampaigns($user);
        $stats['total'] = $campaigns->count();
        
        foreach ($campaigns as $campaign) {
            if (isset($stats[$campaign->status])) {
                $stats[$campaign->status]++;
            }
        }
        
        return $stats;
    }

    public function getPerformanceStats($user = null)
    {
        $user = $user ?? Auth::user();
        
        $campaigns = $this->getAllCampaigns($user);
        
        $stats = [
            'impressions' => 0,
            'clicks' => 0,
            'conversions' => 0,
            'budget' => 0,
            'spent' => 0
        ];
        
        foreach ($campaigns as $campaign) {
            $stats['impressions'] += $campaign->impressions;
            $stats['clicks'] += $campaign->clicks;
            $stats['conversions'] += $campaign->conversions;
            $stats['budget'] += $campaign->budget;
            $stats['spent'] += $campaign->spent;
        }
        
        // Calculate rates
        $stats['ctr'] = $stats['impressions'] > 0 ? round(($stats['clicks'] / $stats['impressions']) * 100, 2) : 0;
        $stats['conversionRate'] = $stats['clicks'] > 0 ? round(($stats['conversions'] / $stats['clicks']) * 100, 2) : 0;
        
        return $stats;
    }
} 
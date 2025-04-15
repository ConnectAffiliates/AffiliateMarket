<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('advertiser')) {
            return redirect()->route('advertiser.dashboard');
        }

        if ($user->hasRole('affiliate')) {
            return redirect()->route('affiliate.dashboard');
        }

        // Fallback to affiliate dashboard if no role is set
        return redirect()->route('affiliate.dashboard');
    }
} 
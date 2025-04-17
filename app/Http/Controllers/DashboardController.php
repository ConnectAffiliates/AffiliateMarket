<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('advertiser')) {
            return redirect()->route('advertiser.dashboard');
        }

        if ($user->hasRole('affiliate')) {
            return redirect()->route('affiliate.dashboard');
        }

        // If no role is set, redirect to home
        return redirect()->route('home');
    }
} 
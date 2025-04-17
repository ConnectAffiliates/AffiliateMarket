<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AffiliateController extends Controller
{
    public function index()
    {
        return Inertia::render('Advertiser/Affiliates');
    }
} 
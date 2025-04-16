<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/about', function () {
    return Inertia::render('About');
});

Route::get('/advertiser/dashboard', function () {
    return Inertia::render('advertisers/Dashboard');
})->name('advertiser.dashboard');

Route::get('/advertiser/campaigns', function () {
    return Inertia::render('advertisers/Campaigns');
})->name('advertiser.campaigns');

Route::get('/advertiser/affiliateLinks', function () {
    return Inertia::render('advertisers/AffiliateLinks');
})->name('advertiser.affiliateLinks');

Route::get('/advertiser/payouts', function () {
    return Inertia::render('advertisers/Payouts');
})->name('advertiser.payouts');

Route::get('/auth', function () {
    return Inertia::render('auth/Login');
});

Route::get('/login', function () {
    return Inertia::render('Register');
});

// Database Test Route (for debugging)
Route::get('/test-db', function() {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'success',
            'message' => 'Database connection successful',
            'database' => DB::connection()->getDatabaseName()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Database connection failed',
            'error' => $e->getMessage()
        ], 500);
    }
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

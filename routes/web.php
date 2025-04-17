<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Affiliate routes
    Route::middleware(CheckRole::class . ':affiliate')->group(function () {
        Route::get('/affiliate/dashboard', function () {
            return Inertia::render('Affiliate/Dashboard');
        })->name('affiliate.dashboard');
    });
    
    // Advertiser routes
    Route::middleware(CheckRole::class . ':advertiser')->group(function () {
        Route::get('/advertiser/dashboard', function () {
            return Inertia::render('Advertiser/Dashboard');
        })->name('advertiser.dashboard');
    });
    
    // Admin routes
    Route::middleware(CheckRole::class . ':admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('admin.dashboard');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/terms', function () {
    return Inertia::render('Legal/Terms');
})->name('terms');

Route::get('/privacy', function () {
    return Inertia::render('Legal/Privacy');
})->name('privacy');

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

// Advertiser routes
Route::middleware(['auth', CheckRole::class . ':advertiser'])->prefix('advertiser')->name('advertiser.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Advertiser\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/campaigns', [App\Http\Controllers\Advertiser\CampaignController::class, 'index'])->name('campaigns');
    Route::get('/campaigns/create', [App\Http\Controllers\Advertiser\CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [App\Http\Controllers\Advertiser\CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/referrals', [App\Http\Controllers\Advertiser\ReferralController::class, 'index'])->name('referrals');
    Route::get('/verify-sales', [App\Http\Controllers\Advertiser\VerifySalesController::class, 'index'])->name('verify-sales');
    Route::get('/affiliates', [App\Http\Controllers\Advertiser\AffiliateController::class, 'index'])->name('affiliates');
    Route::get('/payouts', [App\Http\Controllers\Advertiser\PayoutController::class, 'index'])->name('payouts');
    Route::get('/settings', [App\Http\Controllers\Advertiser\SettingsController::class, 'index'])->name('settings');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

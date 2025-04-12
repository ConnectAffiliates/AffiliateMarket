<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

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

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Add other authenticated routes here
});

// Include additional route files
require __DIR__.'/auth.php';    // Authentication routes (login, register, etc.)
require __DIR__.'/settings.php'; // Application settings routes
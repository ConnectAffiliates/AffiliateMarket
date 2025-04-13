<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Home');
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

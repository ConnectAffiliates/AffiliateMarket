<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user()->load('roles', 'permissions');
    });

    Route::apiResource('users', UserController::class)->except(['store']);
    
    // Admin-only routes
    Route::middleware(\App\Http\Middleware\CheckUserRole::class . ':admin')->group(function () {
        Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole']);
        Route::post('/users/{user}/remove-role', [UserController::class, 'removeRole']);
    });
});
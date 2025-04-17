<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\UserService;
use App\Services\RoleService;
use App\Services\PermissionService;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Contracts\RoleServiceInterface;
use App\Services\Contracts\PermissionServiceInterface;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(PermissionServiceProvider::class);
        
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(PermissionServiceInterface::class, PermissionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
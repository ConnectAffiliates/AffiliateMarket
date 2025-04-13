<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Define gates for permissions
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });

        // Dynamically register permissions
        foreach (config('permissions') as $permission) {
            Gate::define($permission['name'], function (User $user) use ($permission) {
                return $user->hasPermission($permission['name']);
            });
        }
    }
}
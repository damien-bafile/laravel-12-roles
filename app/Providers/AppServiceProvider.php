<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register a custom gate to check if the user is a super admin
        Gate::before(function ($user, $ability) {
            return ($user->hasRole('Super Admin')) ? true : null;
        });
        // Register a custom gate to check if the user is an admin
        // TODO: Add a check for the 'Admin' role
//        Gate::define('isAdmin', function ($user) {
//            return $user->hasRole('Admin');
//        });
        // Set the default pagination view to Bootstrap 5
        Paginator::useBootstrapFive();
    }
}

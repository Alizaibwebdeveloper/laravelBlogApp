<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Session;

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
        // Redirect an Authenticate user to Dashboard

        RedirectIfAuthenticated::redirectUsing(function(){
            return route('admin.dashboard');
        });

        // Redirect No Authenticated user to Admin login page

        Authenticate::redirectUsing(function(){
            session()->flash('fail', 'You must be logged in to access admin area. please login to continue');
            return route('admin.login');
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\URL;

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

    // untuk ngrok
    // public function boot()
    // {
    //     URL::forceScheme('https');
    // }

    public function boot(): void
    {
        //
    }
}

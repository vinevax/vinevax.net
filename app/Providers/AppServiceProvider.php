<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use VineVax\SteamPHPApi\SteamClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SteamClient::class, function ($app) {
           return new SteamClient(
               config('steam.api_key')
           );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

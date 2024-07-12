<?php

namespace App\Providers;

use App\Services\BreweryService;
use App\Interfaces\BreweryServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BreweryServiceInterface::class, BreweryService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

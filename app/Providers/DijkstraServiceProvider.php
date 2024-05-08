<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DijkstraService;
class DijkstraServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(DijkstraService::class, function ($app) {
            return new DijkstraService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

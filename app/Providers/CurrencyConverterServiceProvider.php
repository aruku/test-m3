<?php

namespace App\Providers;

use App\Services\CurrencyConverterInterface;
use App\Services\DefaultCurrencyConverterService;
use Illuminate\Support\ServiceProvider;

class CurrencyConverterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CurrencyConverterInterface::class,
            function ($app) {
                return app(DefaultCurrencyConverterService::class);
            }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

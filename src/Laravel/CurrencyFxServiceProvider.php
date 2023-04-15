<?php

namespace CurrencyFX\Laravel;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

class CurrencyFxServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        AboutCommand::add('ShipSaaS/Currency-FX', fn () => ['Version' => '1.0.0']);

        $this->mergeConfigFrom(
            __DIR__ . '/Configs/currency-fx.php',
            'currency-fx'
        );

        $this->publishes([
            __DIR__.'/Configs/currency-fx.php' => config_path('currency-fx.php'),
        ]);
    }

    public function register(): void
    {

    }
}
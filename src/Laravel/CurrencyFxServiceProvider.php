<?php

namespace CurrencyFX\Laravel;

use CurrencyFX\Services\CurrencyCloudService;
use CurrencyFX\Services\CurrencyLayerService;
use CurrencyFX\Services\ExchangerRateHostService;
use CurrencyFX\Services\ExchangerRatesApiIoService;
use CurrencyFX\Services\FixerIoService;
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
        ], 'currency-fx-configs');
    }

    public function register(): void
    {
        $this->app->singleton(CurrencyCloudService::class, function () {
            return new CurrencyCloudService(
                config('currency-fx.currencycloud.host'),
                config('currency-fx.currencycloud.login-id'),
                config('currency-fx.currencycloud.api-key')
            );
        });

        $this->app->singleton(ExchangerRateHostService::class);

        $this->app->singleton(CurrencyLayerService::class, function () {
            return new CurrencyLayerService(
                config('currency-fx.currencylayer.host'),
                config('currency-fx.currencylayer.api-key')
            );
        });

        $this->app->singleton(FixerIoService::class, function () {
            return new CurrencyLayerService(
                config('currency-fx.fixer-io.host'),
                config('currency-fx.fixer-io.api-key')
            );
        });

        $this->app->singleton(ExchangerRatesApiIoService::class, function () {
            return new CurrencyLayerService(
                config('currency-fx.exchangeratesapi-io.host'),
                config('currency-fx.exchangeratesapi-io.api-key')
            );
        });
    }
}
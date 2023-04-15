<?php

namespace CurrencyFX\Laravel;

use CurrencyFX\CurrencyFx;
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
        AboutCommand::add('ShipSaaS/Currency-FX', fn () => ['Version' => CurrencyFx::VERSION]);

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
                config('currency-fx.drivers.currencycloud.host'),
                config('currency-fx.drivers.currencycloud.login-id'),
                config('currency-fx.drivers.currencycloud.api-key')
            );
        });

        $this->app->singleton(ExchangerRateHostService::class, function () {
            return new ExchangerRateHostService(
                config('currency-fx.drivers.exchangerate-host.host'),
                'free-api'
            );
        });

        $this->app->singleton(CurrencyLayerService::class, function () {
            return new CurrencyLayerService(
                config('currency-fx.drivers.currencylayer.host'),
                config('currency-fx.drivers.currencylayer.api-key')
            );
        });

        $this->app->singleton(FixerIoService::class, function () {
            return new FixerIoService(
                config('currency-fx.drivers.fixer-io.host'),
                config('currency-fx.drivers.fixer-io.api-key')
            );
        });

        $this->app->singleton(ExchangerRatesApiIoService::class, function () {
            return new ExchangerRatesApiIoService(
                config('currency-fx.drivers.exchangeratesapi-io.host'),
                config('currency-fx.drivers.exchangeratesapi-io.api-key')
            );
        });
    }
}
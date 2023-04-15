<?php

namespace CurrencyFX\Tests\Integration\Laravel;

use CurrencyFX\CurrencyFx;
use CurrencyFX\Services\CurrencyCloudService;
use CurrencyFX\Services\CurrencyLayerService;
use CurrencyFX\Services\ExchangerRateHostService;
use CurrencyFX\Services\ExchangerRatesApiIoService;
use CurrencyFX\Services\FixerIoService;
use CurrencyFX\Tests\Integration\IntegrationTestCase;

class ContainerTest extends IntegrationTestCase
{
    public function testArtisanCommandReturnsTheVersionOfThePackage()
    {
        $this->artisan('about')
            ->expectsOutputToContain('ShipSaaS/Currency-FX')
            ->expectsOutputToContain(CurrencyFx::VERSION);
    }

    public function testContainerReturnsTheBoundCurrencyCloudService()
    {
        config([
            'currency-fx.drivers.currencycloud.api-key' => 'test',
            'currency-fx.drivers.currencycloud.login-id' => 'me@sethphat.dev',
        ]);
        $service = app(CurrencyCloudService::class);

        $this->assertNotNull($service);
        $this->assertInstanceOf(CurrencyCloudService::class, $service);
    }

    public function testContainerReturnsTheBoundCurrencyLayerService()
    {
        config([
            'currency-fx.drivers.currencylayer.api-key' => 'test',
        ]);
        $service = app(CurrencyLayerService::class);

        $this->assertNotNull($service);
        $this->assertInstanceOf(CurrencyLayerService::class, $service);
    }

    public function testContainerReturnsTheBoundFixerIoService()
    {
        config([
            'currency-fx.drivers.fixer-io.api-key' => 'test',
        ]);
        $service = app(FixerIoService::class);

        $this->assertNotNull($service);
        $this->assertInstanceOf(FixerIoService::class, $service);
    }

    public function testContainerReturnsTheBoundExchangeRateHostService()
    {
        $service = app(ExchangerRateHostService::class);

        $this->assertNotNull($service);
        $this->assertInstanceOf(ExchangerRateHostService::class, $service);
    }

    public function testContainerReturnsTheBoundExchangeRatesApiIoService()
    {
        config([
            'currency-fx.drivers.exchangeratesapi-io.api-key' => 'test',
        ]);
        $service = app(ExchangerRatesApiIoService::class);

        $this->assertNotNull($service);
        $this->assertInstanceOf(ExchangerRatesApiIoService::class, $service);
    }
}
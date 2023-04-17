<?php

namespace CurrencyFX\Tests\E2E\Services;

use CurrencyFX\Services\ExchangerRateHostService;
use CurrencyFX\Services\ExchangerRatesApiIoService;
use CurrencyFX\Tests\E2E\E2ETestCase;

class ExchangerRatesApiIoServiceTest extends E2ETestCase
{
    public function testGetRates()
    {
        $rate = app(ExchangerRatesApiIoService::class)->getRates('USD', 'VND');

        $this->assertTrue($rate->isOk());
        $this->assertGreaterThan(22_000, $rate->getOkResult()->rate);
    }
}
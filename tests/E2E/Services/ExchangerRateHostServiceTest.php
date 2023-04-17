<?php

namespace CurrencyFX\Tests\E2E\Services;

use CurrencyFX\Services\ExchangerRateHostService;
use CurrencyFX\Tests\E2E\E2ETestCase;

class ExchangerRateHostServiceTest extends E2ETestCase
{
    public function testGetRates()
    {
        $rate = app(ExchangerRateHostService::class)->getRates('USD', 'GBP');

        $this->assertTrue($rate->isOk());
        $this->assertLessThanOrEqual(1, $rate->getOkResult()->rate);
    }
}
<?php

namespace CurrencyFX\Tests\E2E\Services;

use CurrencyFX\Services\CurrencyLayerService;
use CurrencyFX\Tests\E2E\E2ETestCase;

class CurrencyLayerServiceTest extends E2ETestCase
{
    public function testGetRates()
    {
        $rate = app(CurrencyLayerService::class)->getRates('USD', 'GBP');

        $this->assertTrue($rate->isOk());
        $this->assertLessThanOrEqual(1, $rate->getOkResult()->rate);
    }
}
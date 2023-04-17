<?php

namespace CurrencyFX\Tests\E2E\Services;

use CurrencyFX\Services\FixerIoService;
use CurrencyFX\Tests\E2E\E2ETestCase;

class FixerIoServiceTest extends E2ETestCase
{
    public function testGetRates()
    {
        $rate = app(FixerIoService::class)->getRates('USD', 'JPY');

        $this->assertTrue($rate->isOk());
        $this->assertGreaterThan(50, $rate->getOkResult()->rate);
    }
}
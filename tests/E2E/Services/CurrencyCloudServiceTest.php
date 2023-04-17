<?php

namespace CurrencyFX\Tests\E2E\Services;

use CurrencyFX\Services\CurrencyCloudService;
use CurrencyFX\Tests\E2E\E2ETestCase;

class CurrencyCloudServiceTest extends E2ETestCase
{
    public function testGetRates()
    {
        if (now()->utc()->isWeekend()) {
            $this->markTestSkipped('CurrencyCloud does not support get rates on weekend');
        }

        $rateUsd = app(CurrencyCloudService::class)->getRates('USD', 'SGD');

        $this->assertTrue($rateUsd->isOk());
        $this->assertGreaterThan(1, $rateUsd->getOkResult()->rate);

        $rateSgd = app(CurrencyCloudService::class)->getRates('SGD', 'USD');
        $this->assertTrue($rateSgd->isOk());
        $this->assertLessThanOrEqual(1, $rateSgd->getOkResult()->rate);
    }
}
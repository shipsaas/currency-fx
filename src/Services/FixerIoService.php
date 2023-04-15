<?php

namespace CurrencyFX\Services;

use CurrencyFX\Contracts\ExternalCurrencyRateInterface;
use CurrencyFX\Services\Outcomes\GetRateOkResult;
use CurrencyFX\Services\Outcomes\GetRateResult;

class FixerIoService implements ExternalCurrencyRateInterface
{
    public function __construct(
        private string $host,
        private string $apiKey
    ) {
    }

    public function getRates(string $fromCurrency, string $toCurrency): GetRateResult
    {
        return GetRateResult::ok(new GetRateOkResult(1, 1));
    }
}
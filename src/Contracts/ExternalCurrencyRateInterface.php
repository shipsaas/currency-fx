<?php

namespace CurrencyFX\Contracts;

use CurrencyFX\Services\Outcomes\GetRateResult;

interface ExternalCurrencyRateInterface
{
    public function getRates(string $fromCurrency, string $toCurrency): GetRateResult;
}
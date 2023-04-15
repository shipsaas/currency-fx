<?php

namespace CurrencyFX\Services;

use CurrencyFX\Contracts\ExternalCurrencyRateInterface;
use CurrencyFX\Services\Outcomes\GetRateOkResult;
use CurrencyFX\Services\Outcomes\GetRateResult;

/**
 * Based on the documentation, it is having the same approach to get the rate
 *
 * So we only need to pass the correct config, and it should work
 *
 * @see https://exchangerate.host/#/#docs
 */
class ExchangerRateHostService extends ExchangerRatesApiIoService implements ExternalCurrencyRateInterface
{
}
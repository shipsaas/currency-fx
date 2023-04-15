<?php

namespace CurrencyFX\Services;

use CurrencyFX\Contracts\ExternalCurrencyRateInterface;

/**
 * Based on the documentation, it is having the same approach to get the rate
 *
 * So we only need to pass the correct config, and it should work
 *
 * @see https://apilayer.com/marketplace/fixer-api#endpoints
 */
class FixerIoService extends ExchangerRatesApiIoService implements ExternalCurrencyRateInterface
{
}
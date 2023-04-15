<?php

namespace CurrencyFX\Services;

use CurrencyFX\Contracts\ExternalCurrencyRateInterface;
use CurrencyFX\Enums\GetRateErrorOutcome;
use CurrencyFX\Services\Outcomes\GetRateErrorResult;
use CurrencyFX\Services\Outcomes\GetRateOkResult;
use CurrencyFX\Services\Outcomes\GetRateResult;

class CurrencyCloudService implements ExternalCurrencyRateInterface
{
    private readonly string $authToken;

    public function __construct(
        public string $host,
        public string $loginId,
        public string $apiKey
    ) {
    }

    private function getAuthToken(): bool
    {
        if (isset($this->authToken)) {
            return true;
        }

        return true;
    }

    public function getRates(string $fromCurrency, string $toCurrency): GetRateResult
    {
        if (!$this->getAuthToken()) {
            return GetRateResult::error(new GetRateErrorResult(GetRateErrorOutcome::AUTHENTICATION_FAILED));
        }

        return GetRateResult::ok(new GetRateOkResult(1, 1));
    }
}
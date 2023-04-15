<?php

namespace CurrencyFX\Services;

use CurrencyFX\Contracts\ExternalCurrencyRateInterface;
use CurrencyFX\Enums\GetRateErrorOutcome;
use CurrencyFX\Services\HttpClient\CurrencyFxClient;
use CurrencyFX\Services\Outcomes\GetRateErrorResult;
use CurrencyFX\Services\Outcomes\GetRateOkResult;
use CurrencyFX\Services\Outcomes\GetRateResult;

class CurrencyLayerService implements ExternalCurrencyRateInterface
{
    private CurrencyFxClient $httpClient;

    public function __construct(
        private string $host,
        private string $apiKey
    ) {
        $this->httpClient = CurrencyFxClient::getClient($this->host, [
            'apikey' => $this->apiKey,
        ]);
    }

    public function getRates(string $fromCurrency, string $toCurrency): GetRateResult
    {
        $getRate = $this->httpClient->request('GET', 'live', [
            'query' => [
                'source' => $fromCurrency,
                'currencies' => $toCurrency,
            ],
        ]);

        if (!$getRate->isOk) {
            return GetRateResult::error(new GetRateErrorResult(GetRateErrorOutcome::RETRIEVE_RATE_FAILED));
        }

        $pair = $fromCurrency . $toCurrency;

        return GetRateResult::ok(new GetRateOkResult($getRate->response['quotes'][$pair]));
    }
}
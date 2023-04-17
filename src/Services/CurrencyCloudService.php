<?php

namespace CurrencyFX\Services;

use CurrencyFX\Contracts\ExternalCurrencyRateInterface;
use CurrencyFX\Enums\GetRateErrorOutcome;
use CurrencyFX\Services\HttpClient\CurrencyFxClient;
use CurrencyFX\Services\Outcomes\GetRateErrorResult;
use CurrencyFX\Services\Outcomes\GetRateOkResult;
use CurrencyFX\Services\Outcomes\GetRateResult;

class CurrencyCloudService implements ExternalCurrencyRateInterface
{
    private readonly string $authToken;
    private CurrencyFxClient $httpClient;

    public function __construct(
        private readonly string $host,
        private readonly string $loginId,
        private readonly string $apiKey
    ) {
        $this->httpClient = CurrencyFxClient::getClient($this->host);
    }

    private function getAuthToken(): bool
    {
        if (isset($this->authToken)) {
            return true;
        }

        $authResponse = $this->httpClient->request('POST', 'v2/authenticate/api', [
            'multipart' => [
                [
                    'name' => 'login_id',
                    'contents' => $this->loginId,
                ],
                [
                    'name' => 'api_key',
                    'contents' => $this->apiKey,
                ],
            ],
        ]);

        if (!$authResponse->isOk) {
            return false;
        }

        $this->authToken = $authResponse->response['auth_token'];

        return true;
    }

    public function getRates(string $fromCurrency, string $toCurrency): GetRateResult
    {
        if (!$this->getAuthToken()) {
            return GetRateResult::error(new GetRateErrorResult(GetRateErrorOutcome::AUTHENTICATION_FAILED));
        }

        $getRate = $this->httpClient->request('GET', 'v2/rates/detailed', [
             'headers' => [
                 'X-Auth-Token' => $this->authToken,
             ],
            'query' => [
                'sell_currency' => $fromCurrency,
                'buy_currency' => $toCurrency,
                'fixed_side' => 'sell',
                'amount' => 10_000,
            ],
        ]);

        if (!$getRate->isOk) {
            return GetRateResult::error(new GetRateErrorResult(GetRateErrorOutcome::RETRIEVE_RATE_FAILED));
        }

        $resolvedRate = $this->transformRate($getRate->response, $fromCurrency, $toCurrency);

        return GetRateResult::ok(new GetRateOkResult($resolvedRate));
    }

    /**
     * CurrencyCloud returns the rate with their own "pair" setting
     * So here, we have to transform if the pair doesn't match our need.
     * Eg: SGD => USD, they always return the USD => SGD rate
     */
    private function transformRate(array $rateResponse, string $fromCurrency, string $toCurrency): float
    {
        $rate = floatval($rateResponse['mid_market_rate'] ?? $rateResponse['core_rate']);

        if ($fromCurrency.$toCurrency === $rateResponse['currency_pair']) {
            return $rate;
        }

        // takes 6 decimal points
        return round(1 / $rate, 6);
    }
}
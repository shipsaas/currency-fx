<?php

namespace CurrencyFX\Tests\Unit\Services;

use CurrencyFX\Enums\GetRateErrorOutcome;
use CurrencyFX\Services\CurrencyCloudService;
use CurrencyFX\Services\HttpClient\ClientResponse;
use CurrencyFX\Services\HttpClient\CurrencyFxClient;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class CurrencyCloudServiceTest extends TestCase
{
    private CurrencyCloudService $service;
    private CurrencyFxClient $httpClient;

    protected function setUp(): void
    {
        $this->service = new CurrencyCloudService(
            'https://devapi.currencycloud.com',
            'fake-login',
            'fake-api'
        );
        $this->httpClient = $this->createMock(CurrencyFxClient::class);

        $reflectorHttpClient = new ReflectionProperty($this->service, 'httpClient');
        $reflectorHttpClient->setAccessible(true);
        $reflectorHttpClient->setValue($this->service, $this->httpClient);
    }

    public function testGetRatesReturnsErrorDueToAuthenticationFailed()
    {
        $response = new ClientResponse();
        $response->isOk = false;
        $response->statusCode = 400;
        $response->response = json_decode(
            file_get_contents(__DIR__ . '/../__fixtures__/currency-cloud-auth-error.json'),
            true
        );

        $this->httpClient->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $rateResult = $this->service->getRates('USD', 'GBP');

        $this->assertFalse($rateResult->isOk());
        $this->assertSame(GetRateErrorOutcome::AUTHENTICATION_FAILED, $rateResult->getErrorResult()->outcome);
    }

    public function testGetRatesReturnsErrorDueToFailedToRetrieveFromCurrencyCloud()
    {
        $authResponse = new ClientResponse();
        $authResponse->isOk = true;
        $authResponse->statusCode = 200;
        $authResponse->response = json_decode(
            file_get_contents(__DIR__ . '/../__fixtures__/currency-cloud-auth.json'),
            true
        );

        $rateResponse = new ClientResponse();
        $rateResponse->isOk = false;
        $rateResponse->statusCode = 400;
        $rateResponse->response = json_decode(
            file_get_contents(__DIR__ . '/../__fixtures__/currency-cloud-rate-error.json'),
            true
        );

        $this->httpClient->expects($this->exactly(2))
            ->method('request')
            ->willReturnOnConsecutiveCalls(
                $authResponse,
                $rateResponse
            );

        $rateResult = $this->service->getRates('USD', 'GBP');

        $this->assertFalse($rateResult->isOk());
        $this->assertSame(GetRateErrorOutcome::RETRIEVE_RATE_FAILED, $rateResult->getErrorResult()->outcome);
    }

    public function testGetRateReturnsOkResponseWithRate()
    {
        $authResponse = new ClientResponse();
        $authResponse->isOk = true;
        $authResponse->statusCode = 200;
        $authResponse->response = json_decode(
            file_get_contents(__DIR__ . '/../__fixtures__/currency-cloud-auth.json'),
            true
        );

        $rateResponse = new ClientResponse();
        $rateResponse->isOk = true;
        $rateResponse->statusCode = 200;
        $rateResponse->response = json_decode(
            file_get_contents(__DIR__ . '/../__fixtures__/currency-cloud-rate.json'),
            true
        );

        $this->httpClient->expects($this->exactly(2))
            ->method('request')
            ->willReturnOnConsecutiveCalls(
                $authResponse,
                $rateResponse
            );

        $rateResult = $this->service->getRates('USD', 'GBP');

        $this->assertTrue($rateResult->isOk());
        $this->assertSame(0.710227, $rateResult->getOkResult()->rate);
    }

    public function testGetRateMultipleTimesWontDoAuthMultipleTimes()
    {
        $authResponse = new ClientResponse();
        $authResponse->isOk = true;
        $authResponse->statusCode = 200;
        $authResponse->response = json_decode(
            file_get_contents(__DIR__ . '/../__fixtures__/currency-cloud-auth.json'),
            true
        );

        $rateResponse = new ClientResponse();
        $rateResponse->isOk = true;
        $rateResponse->statusCode = 200;
        $rateResponse->response = json_decode(
            file_get_contents(__DIR__ . '/../__fixtures__/currency-cloud-rate.json'),
            true
        );

        $this->httpClient->expects($this->exactly(3))
            ->method('request')
            ->willReturnOnConsecutiveCalls(
                $authResponse,
                $rateResponse,
                $rateResponse
            );

        $rateResult = $this->service->getRates('USD', 'GBP');
        $this->assertTrue($rateResult->isOk());
        $this->assertSame(0.710227, $rateResult->getOkResult()->rate);

        $rateResult = $this->service->getRates('USD', 'GBP');
        $this->assertTrue($rateResult->isOk());
        $this->assertSame(0.710227, $rateResult->getOkResult()->rate);
    }
}
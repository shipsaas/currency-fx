<?php

namespace CurrencyFX\Tests\Unit\Services;

use CurrencyFX\Enums\GetRateErrorOutcome;
use CurrencyFX\Services\FixerIoService;
use CurrencyFX\Services\HttpClient\ClientResponse;
use CurrencyFX\Services\HttpClient\CurrencyFxClient;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class FixerIoServiceTest extends TestCase
{
    private FixerIoService $service;
    private CurrencyFxClient $httpClient;

    protected function setUp(): void
    {
        $this->service = new FixerIoService(
            'https://api.exchangerate.host/latest',
            'fake'
        );
        $this->httpClient = $this->createMock(CurrencyFxClient::class);

        $reflectorHttpClient = new ReflectionProperty($this->service, 'httpClient');
        $reflectorHttpClient->setAccessible(true);
        $reflectorHttpClient->setValue($this->service, $this->httpClient);
    }

    public function testGetRatesReturnsRate()
    {
        $response = new ClientResponse();
        $response->isOk = true;
        $response->statusCode = 200;
        $response->response = json_decode(
            file_get_contents(__DIR__ . '/../__fixtures__/fixer-io-rate.json'),
            true
        );

        $this->httpClient->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $rateResult = $this->service->getRates('USD', 'EUR');

        $this->assertTrue($rateResult->isOk());
        $this->assertSame(0.813399, $rateResult->getOkResult()->rate);
    }

    public function testGetRatesReturnsError()
    {
        $response = new ClientResponse();
        $response->isOk = false;
        $response->statusCode = 400;
        $response->response = json_decode(
            file_get_contents(__DIR__ . '/../__fixtures__/fixer-io-rate-error.json'),
            true
        );

        $this->httpClient->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $rateResult = $this->service->getRates('USD', 'EUR');

        $this->assertFalse($rateResult->isOk());
        $this->assertSame(GetRateErrorOutcome::RETRIEVE_RATE_FAILED, $rateResult->getErrorResult()->outcome);
    }
}
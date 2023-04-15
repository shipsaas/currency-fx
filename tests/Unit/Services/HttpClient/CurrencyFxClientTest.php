<?php

namespace CurrencyFX\Tests\Unit\Services\HttpClient;

use CurrencyFX\Services\HttpClient\CurrencyFxClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class CurrencyFxClientTest extends TestCase
{
    public function testCreateNewCurrencyFxClient()
    {
        $client = CurrencyFxClient::getClient('https://github.com/shipsaas');

        $this->assertNotNull($client);
        $this->assertInstanceOf(CurrencyFxClient::class, $client);
    }

    public function testRequestReturnsSuccessResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"ok": true}'),
        ]);

        $client = CurrencyFxClient::getClient('https://github.com/shipsaas', [], [
            'handler' => $mock,
        ]);

        $response = $client->request('GET', 'health-check');

        $this->assertTrue($response->isOk);
        $this->assertSame(200, $response->statusCode);
        $this->assertSame([
            'ok' => true,
        ], $response->response);
    }

    public function testRequestReturnsErrorResponse()
    {
        $mock = new MockHandler([
            new ClientException(
                'Client Error',
                new Request('GET', 'transfer'),
                new Response(400, [], '{"ok": false}'),
            ),
        ]);

        $client = CurrencyFxClient::getClient('https://github.com/shipsaas', [], [
            'handler' => $mock,
        ]);

        $response = $client->request('GET', 'transfer');

        $this->assertFalse($response->isOk);
        $this->assertSame(400, $response->statusCode);
        $this->assertSame([
            'ok' => false,
        ], $response->response);
    }
}
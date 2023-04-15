<?php

namespace CurrencyFX\Services\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class CurrencyFxClient
{
    private Client $client;

    public static function getClient(string $baseUrl, array $headers = []): self
    {
        $fxClient = new self();
        $fxClient->client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'User-Agent' => 'CurrencyFxHTTP/1',
                ...$headers,
            ],
        ]);

        return $fxClient;
    }

    public function request(string $method, string $uri, array $options = []): ClientResponse
    {
        $response = new ClientResponse();

        try {
            $rawResponse = $this->client->request($method, $uri, $options);

            $response->isOk = true;
            $response->statusCode = $rawResponse->getStatusCode();
            $response->response = json_decode($rawResponse->getBody(), true);
        } catch (ClientException | ServerException $exception) {
            $response->isOk = false;
            $response->statusCode = $exception->getResponse()->getStatusCode();
            $response->response = json_decode($exception->getResponse(), true)
                ?: ((string) $exception->getResponse()->getBody());
        }

        return $response;
    }
}
<?php

namespace CurrencyFX\Services\HttpClient;

class ClientResponse
{
    public bool $isOk = true;
    public int $statusCode = 200;
    public array $response = [];
}
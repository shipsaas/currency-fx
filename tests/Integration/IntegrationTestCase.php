<?php

namespace CurrencyFX\Tests\Integration;

use CurrencyFX\Laravel\CurrencyFxServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            CurrencyFxServiceProvider::class,
        ];
    }
}
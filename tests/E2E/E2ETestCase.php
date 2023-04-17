<?php

namespace CurrencyFX\Tests\E2E;

use CurrencyFX\Tests\Integration\IntegrationTestCase;
use Dotenv\Dotenv;
use Illuminate\Support\Env;

abstract class E2ETestCase extends IntegrationTestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        // Load the .env.testing file
        Dotenv::create(
            Env::getRepository(),
            __DIR__ . '/../../',
            '.env.testing',
        )->load();
    }
}
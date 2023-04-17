# PHP Currency FX Library

[![codecov](https://codecov.io/gh/shipsaas/currency-fx/branch/main/graph/badge.svg?token=S1RA9XKU94)](https://codecov.io/gh/shipsaas/currency-fx)
[![Unit Test (PHP 8.1, 8.2)](https://github.com/shipsaas/currency-fx/actions/workflows/unit.yml/badge.svg)](https://github.com/shipsaas/currency-fx/actions/workflows/unit.yml)
[![Integration Test](https://github.com/shipsaas/currency-fx/actions/workflows/integration.yml/badge.svg)](https://github.com/shipsaas/currency-fx/actions/workflows/integration.yml)
[![E2E Test](https://github.com/shipsaas/currency-fx/actions/workflows/e2e.yml/badge.svg)](https://github.com/shipsaas/currency-fx/actions/workflows/e2e.yml)

A PHP Library handles Currency FX (rates & conversions) with ease. Battery-included 🔋🔋🔋.

Available for Laravel too.

Tired of implementing these and integrate with 3rd services? Let's CurrencyFX help you to do that. Covered by Unit Testing & battle-tested!

## Available Services / Batteries
- https://exchangeratesapi.io/
- https://exchangerate.host/
- https://fixer.io/
- https://currencylayer.com/
- https://www.currencycloud.com/

## Supports
- PHP 8.1+

## Dependencies
- Guzzle for API Requests
- [NeverThrow](https://github.com/shipsaas/never-throw) for straightforward OK/Error response.

## Usage

Simply initialize the class with the required params. And it is ready to use in no time.

```php
$service = new CurrencyCloudService($host, $loginId, $apiKey);
$rateResponse = $service->getRates('USD', 'SGD');

if (!$rateResponse->isOk()) {
    // failed to get the rate from third party service
    // do something here
}

$rate = $rateResponse->getOkResult()->rate; // float (1.4xxx)
```

## Laravel Integration

Requirement: Laravel 10+

Just simply install the package and lets Laravel discovery magic happens 🥰

Since we already bind the services in Laravel Container, all you have to do is update the ENVs and that's all.

### Export the configuration

```bash
php artisan vendor:publish --tag=currency-fx-configs
```

### Update ENVs

After published the config, checkout the `configs/currency-fx.php`.

We already defined some ENVs key for you to add 😜.

### Usage

```php
use CurrencyFX\Services\CurrencyLayerService;
use CurrencyFX\Services\ExchangerRatesApiIoService;

// global access
app(CurrencyLayerService::class)->getRates('USD', 'EUR');

// DI
class TransferService
{
    public function __construct(
        private ExchangerRatesApiIoService $rateService
    ) {
    }
    
    public function transfer(): TransferResult
    {
        $rateRes = $this->rateService->getRates('EUR', 'GBP');
        if ($rateRes->isError()) {
            return TransferResult::error(...);
        }

        $rate = $rateRes->getOkResult()->rate;
    }
}
```

## Tests

We love tests, always. We have 3 kind of test cases:

- Unit Tests
- Integration Tests
- E2E Tests

Check out the [TEST-README.md](./tests/README.md) to learn more!

## Contribute to the project

- All changes must follow PSR-1 / PSR-12 coding conventions.
- Unit testing is a must, cover things as much as you can.

Feel free to add more driver and share it to the whole PHP community 😆

## This library is useful?

Thank you, please give it a ⭐️⭐️⭐️ to support the project.

Don't forget to share with your friends & colleagues, so they can also build their own SaaS products as well 🚀

## License
MIT LICENSE

## Contributors
ShipSaas, Seth Phat & Contributors
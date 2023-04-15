# PHP Currency FX

A PHP Library handles Currency FX (rates & conversions) with ease. Available for Laravel too.

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

## Usage

Simply initialize the class with the required params. And it is ready to use in no time.

```php
$service = new CurrencyCloudService($host, $loginId, $apiKey);
$rate = $service->getRates('USD', 'SGD'); // 1.4xxx (float)
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
// global access
app(\CurrencyFX\Services\CurrencyLayerService::class)->getRates('USD', 'EUR');

// DI
class TransferService
{
    public function __construct(
        private \CurrencyFX\Services\ExchangerRatesApiIoService $rateService
    ) {
    }
    
    public function transfer(): TransferResult
    {
        $rates = $this->rateService->getRates('EUR', 'GBP');
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
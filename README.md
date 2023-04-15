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

## Usage

Simply initialize the class with the required params. And it is ready to use in no time.

```php
$service = new CurrencyCloudService($host, $loginId, $apiKey);
$rate = $service->getRates('USD', 'SGD');
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

## License
MIT LICENSE

## Contributors
ShipSaas, Seth Phat & Contributors
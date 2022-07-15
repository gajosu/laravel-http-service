# Laravel Http Client Service

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gajosu/laravel-http-client.svg?style=flat-square)](https://packagist.org/packages/gajosu/laravel-http-client)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/gajosu/laravel-http-client/run-tests?label=tests)](https://github.com/gajosu/laravel-http-client/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/gajosu/laravel-http-client/Check%20&%20fix%20styling?label=code%20style)](https://github.com/gajosu/laravel-http-client/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/gajosu/laravel-http-client.svg?style=flat-square)](https://packagist.org/packages/gajosu/laravel-http-client)

Do you make a lot of http requests to microservices or external apis in your laravel projects?

There are many packages to do this, but I haven't found one that is easy to test and that offers caching functionality.<br>
This package allows you to create your own services, make requests and test them easily.


## Installation

You can install the package via composer:

```bash
composer require gajosu/laravel-http-client
```

## Usage

```php
use Gajosu\LaravelHttpClient\Facades\HttpService;
$builder = HttpService::getBuilder();
$response = $builder->setMethod('GET')
    ->baseUri('http://example.com')
    ->setPath('/test')
    ->setQuery([
        'query1' => 'param'
    ])
    ->send();

$data = $response->jsonDecode();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/gajosu/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Gabriel Gonzalez](https://github.com/gajosu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

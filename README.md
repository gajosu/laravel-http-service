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

You can start using it easily, simply by calling the `getBuilder()` method of the facade `HttpService`

```php
use Gajosu\LaravelHttpClient\Facades\HttpService;

/** @var \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder $builder */
$builder = HttpService::request()
    ->setPath('POST')
    //set base url
    ->setBaseUri('http://example.com')
    //set path
    ->setPath('/test')
    // set headers
    ->setHeaders([
        'Authorization' => 'Basic {YOUR_TOKEN}'
    ])
    //set queries strings
    ->setQuery([
        'query1' => 'param'
    ])
    //set body
    ->setBody([
        'field1' => 'value'
    ]);
// send the request and get response
/** @var \Gajosu\LaravelHttpClient\Response\ApiResponse $response */
$response = $builder->send();
// json data decoded
$data = $response->json();
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

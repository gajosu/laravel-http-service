# Laravel Http Client Service

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gajosu/laravel-http-service.svg?style=flat-square)](https://packagist.org/packages/gajosu/laravel-http-service)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/gajosu/laravel-http-service/run-tests?label=tests)](https://github.com/gajosu/laravel-http-service/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/gajosu/laravel-http-service/Check%20&%20fix%20styling?label=code%20style)](https://github.com/gajosu/laravel-http-service/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/gajosu/laravel-http-service.svg?style=flat-square)](https://packagist.org/packages/gajosu/laravel-http-service)

Do you make a lot of http requests to microservices or external apis in your laravel projects?

There are many packages to do this, but I haven't found one that is easy to test and that offers caching functionality.<br>
This package allows you to create your own services, make requests and test them easily.


## Installation

You can install the package via composer:

```bash
composer require gajosu/laravel-http-service
```

## Usage

You can start using it easily, simply by calling the `request()` method of the facade `HttpService`

```php
use Gajosu\LaravelHttpClient\Facades\HttpService;

/** @var \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder $builder */
$builder = HttpService::request()
    ->setMethod('POST')
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

## Make your own service

As explained in the example above, you can start using the package with its base classes, but the purpose of this package is to make it easy to create your own services.

You can make your own service by extending the `Gajosu\LaravelHttpClient\HttpService` class.<br>
Rewrite the `getBuilder()` method and set Base Uri, headers, queries, etc.

In the next example we will make a service that sends requests to `http://myservice.com` base url and set a access token in the headers.

```php
namespace App\Services\MyService;

use Gajosu\LaravelHttpClient\HttpService;
use Gajosu\LaravelHttpClient\Contracts\HttpRequestBuilder;

class MyService extends HttpService
{
    private ?string $access_token = null;

    public function setAccessToken(string $access_token): void
    {
        $this->access_token = $access_token;
    }

    public function getAccessToken(): ?string
    {
        return $this->access_token;
    }

    public function getBuilder(): HttpRequestBuilder
    {
        return parent::getBuilder()
            ->setBaseUri('http://myservice.com')
            ->setHeaders([
                "Authorization" => "Basic {$this->access_token}"
            ]);
    }
}
```

The next step is to create a facade for the service extending the `Gajosu\LaravelHttpClient\Facades\HttpService` class.

```php
namespace App\Services\MyService\Facades\MyService;

use Gajosu\LaravelHttpClient\Facades\HttpService;

/**
 * @method static void setAccessToken(string $access_token)
 * @method static string getAccessToken()
 */
class MyService extends HttpService
{
    
    protected static function getFacadeAccessor()
    {
        return \App\Services\MyService\MyService::class;
    }
}
```

Now you can use the service in your application.

```php
use App\Services\MyService\Facades\MyService;

MyService::setAccessToken('{YOUR_TOKEN}');
$response = MyService::request()
    ->setMethod('POST')
    ->setPath('/test')
    ->setQuery([
        'query1' => 'param'
    ])
    ->setBody([
        'field1' => 'value'
    ])
    ->send();
$data = $response->json();
```

## Caching Responses

The package also allows you to cache the responses.

```php
use App\Services\MyService\Facades\MyService;

MyService::setAccessToken('{YOUR_TOKEN}');
$response = MyService::request()
    ->setMethod('GET')
    ->setPath('/test')
    ->setQuery([
        'query1' => 'param'
    ])
    //you can set the cache time in seconds
    ->cacheFor(60)
    // or 
    // ->cacheFor(now()->addMinutes(1))
    // you can also keep the cache forever
    // ->cacheForever()
    ->send();
$data = $response->json();
```

## Faking Responses

For example, to instruct the package to return a fake response with code 200 and empty body for all requests, you can use the `fake()` method.

```php
use App\Services\MyService\Facades\MyService;


MyService::fake()
$response = MyService::request()
    ->setMethod('GET')
    ->setPath('/test')
    ->setQuery([
        'query1' => 'param'
    ])
    ->fakeResponse(200, [])
    ->send();
$data = $response->json();
```
### Specifying responses

You can also specify the responses code, headers and body passing an array to the `shouldReceiveResponses` method.

```php
use App\Services\MyService\Facades\MyService;

MyService::fake();
MyService::shouldReceiveResponses([
    [
        new \GuzzleHttp\Psr7\Response(
            status : 200,
            body: '{"success" : true}'
        ),

        new \GuzzleHttp\Psr7\Response(
            status : 201,
            body: '{"created" : true}'
        )
    ]
]);

$response = MyService::request()
    ->setMethod('GET')
    ->setPath('/test')
    ->setQuery([
        'query1' => 'param'
    ])
    ->send();

//get first fake response
// [
//   "success" => true
// ]
$data = $response->json();

//get second fake response
// [
//   "created" => true
// ]
$data = $response->json();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/gajosu/laravel-http-service/blob/main/.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Gabriel Gonzalez](https://github.com/gajosu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

<?php

namespace Gajosu\LaravelHttpClient\Facades;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Facade;
use PHPUnit\Framework\Assert as PHPUnit;
use Gajosu\LaravelHttpClient\Contracts\Service;
use Gajosu\LaravelHttpClient\Builders\ApiRequestBuilderFake;

/**
 * @method static \Gajosu\LaravelHttpClient\Contracts\HttpRequestBuilder getBuilder()
 * @method static \Gajosu\LaravelHttpClient\Contracts\Service setBuilder()
 */
class HttpService extends Facade
{
    /**
     * Replace the builder with a fake one.
     * @return \Gajosu\LaravelHttpClient\Contracts\Service
     */
    public static function fake(): Service
    {
        /** @var \Gajosu\LaravelHttpClient\Contracts\Service */
        $service = static::getFacadeRoot();
        $service->setBuilder(new ApiRequestBuilderFake());
        return $service;
    }

    /**
     * Should receive a responses
     *
     * @param array<\GuzzleHttp\Psr7\Response>|\GuzzleHttp\Psr7\Response $responses
     * @return \Gajosu\LaravelHttpClient\Contracts\Service
     */
    public static function shouldReceiveResponses(array|Response $responses): Service
    {
        /** @var \Gajosu\LaravelHttpClient\Contracts\Service */
        $service = static::getFacadeRoot();
        $builder = $service->getBuilder();

        if (!$builder instanceof ApiRequestBuilderFake) {
            throw new \RuntimeException('You can only use this method on a fake service');
        }

        $builder->shouldReceiveResponses($responses);
        return $service;
    }

    /**
     * Assert the requests number
     *
     * @param int $times
     * @return void
     */
    public static function assertRequestsTimes(int $times): void
    {
        /** @var \Gajosu\LaravelHttpClient\Contracts\Service */
        $service = static::getFacadeRoot();
        PHPUnit::assertEquals(
            $times,
            $service->getBuilder()->getRequestsCount()
        );
    }

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Gajosu\LaravelHttpClient\HttpService::class;
    }
}

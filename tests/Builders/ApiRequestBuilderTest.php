<?php

namespace Gajosu\LaravelHttpClient\Tests\Builders;

use Gajosu\LaravelHttpClient\Request\ApiRequestBuilder;
use Gajosu\LaravelHttpClient\Response\ApiResponse;
use Gajosu\LaravelHttpClient\Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Cache;

class ApiRequestBuilderTest extends TestCase
{
    public function testItCanSetMethod()
    {
        $builder = new ApiRequestBuilder();
        $builder->setMethod('POST');
        $this->assertEquals('POST', $this->getPropertyWithReflection('method', $builder));
    }

    public function testItCanSetBaseUri()
    {
        $builder = new ApiRequestBuilder();
        $builder->setBaseUri('http://example.com');
        $this->assertEquals('http://example.com', $this->getPropertyWithReflection('base_uri', $builder));
    }

    public function testItCanSetPath()
    {
        $builder = new ApiRequestBuilder();
        $builder->setPath('/test');
        $this->assertEquals('/test', $this->getPropertyWithReflection('path', $builder));
    }

    public function testItCanSetHeaders()
    {
        $builder = new ApiRequestBuilder();
        $builder->setHeaders(['X-Test' => 'test']);
        $this->assertEquals(['X-Test' => 'test'], $this->getPropertyWithReflection('headers', $builder));
    }

    public function testItCanSetQuery()
    {
        $builder = new ApiRequestBuilder();
        $builder->setQuery(['test' => 'test']);
        $this->assertEquals(['test' => 'test'], $this->getPropertyWithReflection('query', $builder));
    }

    public function testItCanSetBody()
    {
        $builder = new ApiRequestBuilder();
        $builder->setBody([
            'test' => 'test',
        ]);
        $this->assertEquals([
            'test' => 'test',
        ], $this->getPropertyWithReflection('body', $builder));
    }

    public function testItCanSetMultipart()
    {
        $builder = new ApiRequestBuilder();
        $builder->setMultipart('name', 'content', 'filename');
        $this->assertEquals(
            [
                'name' => 'name',
                'contents' => 'content',
                'filename' => 'filename',
            ],
            $this->getPropertyWithReflection('multipart', $builder)[0]
        );
    }

    public function testItCanSetCacheWithInteger()
    {
        $builder = new ApiRequestBuilder();
        $builder->cacheFor(60);
        $this->assertEquals(60, $this->getPropertyWithReflection('cache_ttl', $builder));
    }

    public function testItCanSetCacheWithDataTime()
    {
        $time = new \DateTime('+1 hour');
        $builder = new ApiRequestBuilder();
        $builder->cacheFor($time);
        $this->assertEquals($time, $this->getPropertyWithReflection('cache_ttl', $builder));
        $this->assertEquals($builder->getCacheTtl(), $time->getTimestamp() - time());
    }

    public function testItCanSetCacheForever()
    {
        $builder = new ApiRequestBuilder();
        $builder->cacheForever();
        $this->assertEquals(-1, $this->getPropertyWithReflection('cache_ttl', $builder));
    }

    public function testItCanSendRequest()
    {
        $builder = $this->getMockRequestBuilder();
        $builder->setMethod('GET');
        $builder->setBaseUri('http://example.com');
        $response = $builder->send();
        $this->assertInstanceOf(ApiResponse::class, $response);
    }

    public function testItCanSendRequestWithTemporalCache()
    {
        $builder = $this->getMockRequestBuilder();
        $builder->setMethod('GET');
        $builder->setBaseUri('http://example.com');
        $builder->cacheFor(now()->addMinutes(1));
        $builder->send();
        $builder->send();
        $builder->send();

        $cache_key = $builder->getCacheKey();
        $this->assertNotNull(Cache::get($cache_key));
        $this->assertEquals(1, $builder->getRequestsCount());

        $this->travelTo(now()->addMinutes(2));
        $this->assertNull(Cache::get($cache_key));
    }

    public function testItCanSendRequestWithForeverCache()
    {
        $builder = $this->getMockRequestBuilder();
        $builder->setMethod('GET');
        $builder->setBaseUri('http://example.com');
        $builder->cacheForever();
        $builder->send();
        $builder->send();

        $cache_key = $builder->getCacheKey();
        $this->assertNotNull(Cache::get($cache_key));
        $this->assertEquals(1, $builder->getRequestsCount());

        $this->travelTo(now()->years(20));
        $this->assertNotNull(Cache::get($cache_key));
    }

    public function testItCanSendRequestAndGetFromCache()
    {
        $builder = new ApiRequestBuilder();
        $builder->setMethod('GET');
        $builder->setBaseUri('http://example.com');
        $builder->cacheFor(now()->addMinutes(1));

        $cache_key = $builder->getCacheKey();
        $fakeResponse = new ApiResponse(new Response(200, [], '{"test": "test"}'));

        Cache::put($cache_key, $fakeResponse, now()->addMinutes(1));
        $response = $builder->send();
        $this->assertEquals($fakeResponse, $response);
        $this->assertEquals(0, $builder->getRequestsCount());
    }

    public function testItCanSetVerify()
    {
        $builder = new ApiRequestBuilder();
        $builder->setVerifySsl(false);
        $this->assertEquals(false, $this->getPropertyWithReflection('verify_ssl', $builder));
    }

    /**
     * @return ApiRequestBuilder
     */
    private function getMockRequestBuilder()
    {
        $builder = $this->getMockBuilder(ApiRequestBuilder::class)
            ->onlyMethods(['getclient'])
            ->getMock();

        $builder->expects($this->once())
            ->method('getclient')
            ->willReturn($this->getMockGuzzleClient());

        return $builder;
    }

    private function getMockGuzzleClient()
    {
        return new Client([
            'handler' => HandlerStack::create(
                new MockHandler(
                    [
                        new Response(200, [], '{"test": "test"}'),
                    ]
                )
            ),
        ]);
    }
}

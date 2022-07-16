<?php

namespace Gajosu\LaravelHttpClient\Tests\Services;

use Gajosu\LaravelHttpClient\Contracts\Service;
use Gajosu\LaravelHttpClient\Facades\HttpService;
use Gajosu\LaravelHttpClient\Request\ApiRequestBuilder;
use Gajosu\LaravelHttpClient\Request\ApiRequestBuilderFake;
use Gajosu\LaravelHttpClient\Tests\Fixtures\CustomServiceFacade;
use Gajosu\LaravelHttpClient\Tests\Fixtures\CustomServiceTwoFacade;
use Gajosu\LaravelHttpClient\Tests\TestCase;
use GuzzleHttp\Psr7\Response;

class ServicesTest extends TestCase
{
    public function testDefaultService()
    {
        $builder = HttpService::getBuilder();
        $this->assertInstanceOf(ApiRequestBuilder::class, $builder);
    }

    public function testFakeService()
    {
        $fake = HttpService::fake();
        $this->assertInstanceOf(Service::class, $fake);

        HttpService::shouldReceiveResponses(
            $fake_response = new Response(200, [], '{"foo": "bar"}'),
        );

        $builder = HttpService::getBuilder();
        $response = $builder->setPath('http://example.com')
            ->send();

        $this->assertInstanceOf(ApiRequestBuilderFake::class, $builder);
        $this->assertEquals($fake_response, $response->getOriginalResponse());
        HttpService::assertRequestsTimes(1);
    }

    public function fakeMultipleServices()
    {
        //default service
        $fake = HttpService::fake();
        $this->assertInstanceOf(Service::class, $fake);
        HttpService::shouldReceiveResponses(
            $fake_response1 = new Response(200, [], '{"foo": "bar"}'),
        );

        //service 2
        $fake = CustomServiceFacade::fake();
        $this->assertInstanceOf(Service::class, $fake);
        CustomServiceFacade::shouldReceiveResponses(
            $fake_response2 = new Response(200, [], '{"foo": "bar2"}'),
        );

        //service 3
        $fake = CustomServiceTwoFacade::fake();
        $this->assertInstanceOf(Service::class, $fake);
        CustomServiceTwoFacade::shouldReceiveResponses(
            $fake_response3 = new Response(200, [], '{"foo": "bar3"}'),
        );

        //Test requests
        //service 1
        $builder = HttpService::getBuilder();
        $response = $builder->setPath('http://example.com')->send();
        $this->assertInstanceOf(ApiRequestBuilderFake::class, $builder);
        $this->assertEquals($fake_response1, $response->getOriginalResponse());

        //service 2
        $builder = CustomServiceFacade::getBuilder();
        $response = $builder->setPath('http://example.com')->send();
        $this->assertEquals($fake_response2, $response->getOriginalResponse());

        //service 3
        $builder = CustomServiceTwoFacade::getBuilder();
        $response = $builder->setPath('http://example.com')->send();
        $this->assertEquals($fake_response3, $response->getOriginalResponse());
    }
}

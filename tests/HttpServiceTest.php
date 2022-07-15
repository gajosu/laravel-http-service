<?php

namespace Gajosu\LaravelHttpClient\Tests;

use Gajosu\LaravelHttpClient\Request\ApiRequestBuilderFake;
use Gajosu\LaravelHttpClient\HttpService;

class HttpServiceTest extends TestCase
{
    public function testSetAndGetBuilder()
    {
        $service = new HttpService();
        $service->setBuilder(new ApiRequestBuilderFake());
        $this->assertInstanceOf(ApiRequestBuilderFake::class, $service->getBuilder());
    }
}

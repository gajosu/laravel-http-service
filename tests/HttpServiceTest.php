<?php

namespace Gajosu\LaravelHttpClient\Tests;

use Gajosu\LaravelHttpClient\HttpService;
use Gajosu\LaravelHttpClient\Request\ApiRequestBuilderFake;

class HttpServiceTest extends TestCase
{
    public function testSetAndGetBuilder()
    {
        $service = new HttpService();
        $service->setBuilder(new ApiRequestBuilderFake());
        $this->assertInstanceOf(ApiRequestBuilderFake::class, $service->getBuilder());
    }
}

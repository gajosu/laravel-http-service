<?php

namespace Gajosu\LaravelHttpClient\Tests\Builders;

use Gajosu\LaravelHttpClient\Builders\ApiRequestBuilderFake;
use Gajosu\LaravelHttpClient\Tests\TestCase;
use GuzzleHttp\Psr7\Response;

class ApiRequestBuilderFakeTest extends TestCase
{
    public function testShouldReceiveResponses()
    {
        $builder = new ApiRequestBuilderFake();
        $builder->shouldReceiveResponses([
            $fake_response = new Response(200, [], '{"test": "test"}'),
        ]);
        $this->assertEquals(
            [
                $fake_response,
            ],
            $this->getPropertyWithReflection('responses', $builder)
        );
    }

    public function testShouldReceiveResponsesWithMultiple()
    {
        $builder = new ApiRequestBuilderFake();
        $builder->shouldReceiveResponses([
            $fake_response = new Response(200, [], '{"test": "test"}'),
            $fake_response2 = new Response(200, [], '{"test": "test"}'),
        ]);
        $this->assertEquals(
            [
                $fake_response,
                $fake_response2,
            ],
            $this->getPropertyWithReflection('responses', $builder)
        );
    }

    public function testGetFakesResponses()
    {
        $builder = new ApiRequestBuilderFake();
        $builder->shouldReceiveResponses([
            $fake_response = new Response(200, [], '{"test": "test"}'),
            $fake_response2 = new Response(200, [], '{"test": "test2"}'),
        ]);

        $builder->setMethod('GET');
        $builder->setPath('/test');

        //first response
        $response = $builder->send();
        $this->assertEquals($fake_response, $response->getOriginalResponse());

        //second response
        $response = $builder->send();
        $this->assertEquals($fake_response2, $response->getOriginalResponse());
    }
}

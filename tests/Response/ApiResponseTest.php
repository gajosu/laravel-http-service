<?php

namespace Gajosu\LaravelHttpClient\Tests\Builders;

use Gajosu\LaravelHttpClient\Response\ApiResponse;
use Gajosu\LaravelHttpClient\Tests\TestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class ApiResponseTest extends TestCase
{
    public function testGetBody()
    {
        $response = new Response(200, [], 'test');

        $api_response = new ApiResponse($response);

        $this->assertEquals('test', $api_response->body());
    }

    public function testJsonDecode()
    {
        $data = [
            'test' => 'test',
            'sub' => [
                'test' => 'test',
            ],
        ];

        $response = new Response(200, [], json_encode($data));
        $api_response = new ApiResponse($response);

        $this->assertEquals($data, $api_response->json());
        $this->assertEquals($data['test'], $api_response->json('test'));
        $this->assertEquals($data['sub'], $api_response->json('sub'));
        $this->assertEquals($data['sub']['test'], $api_response->json('sub.test'));
    }

    public function testJsonDecodeObject()
    {
        $data = [
            'test' => 'test',
            'sub' => [
                'test' => 'test',
            ],
        ];

        $response = new Response(200, [], json_encode($data));
        $api_response = new ApiResponse($response);

        $this->assertEquals(json_decode(json_encode($data)), $api_response->object());
    }

    public function testToCollection()
    {
        $data = [
            'test' => 'test',
            'sub' => [
                [
                    'test' => 'test',
                    'sub' => [
                        'test' => 'test',
                    ],
                ],
            ],
        ];

        $response = new Response(200, [], json_encode($data));
        $api_response = new ApiResponse($response);

        $this->assertEquals(new Collection($data), $api_response->collect());
        $this->assertEquals(new Collection($data['sub']), $api_response->collect('sub'));
    }

    public function testHeaders()
    {
        $response = new Response(200, [
            'header1' => 'value1',
            'header2' => 'value2',
        ]);

        $api_response = new ApiResponse($response);

        $this->assertEquals($response->getHeaders(), $api_response->headers());
        $this->assertEquals($response->getHeader('header1')[0], $api_response->header('header1'));
    }

    public function testGetStatusCode()
    {
        $response = new Response(200);

        $api_response = new ApiResponse($response);

        $this->assertEquals(200, $api_response->status());
    }

    public function testGetReasonPhrase()
    {
        $response = new Response(200, [], 'test');

        $api_response = new ApiResponse($response);

        $this->assertEquals('OK', $api_response->reason());
    }
}

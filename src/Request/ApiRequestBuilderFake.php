<?php

namespace Gajosu\LaravelHttpClient\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ApiRequestBuilderFake extends ApiRequestBuilder
{
    /** @var array<\GuzzleHttp\Psr7\Response> */
    protected array $responses = [];

    /**
     * Should receive a responses
     *
     * @param array<\GuzzleHttp\Psr7\Response>|\GuzzleHttp\Psr7\Response $responses
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilderFake
     */
    public function shouldReceiveResponses(array|Response $responses): self
    {
        if (! is_array($responses)) {
            $responses = [$responses];
        }

        foreach ($responses as $response) {
            $this->addResponse($response);
        }

        return $this;
    }

    /**
     * Get HTTP client
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient(): Client
    {
        return new Client([
            'base_uri' => $this->base_uri,
            'handler' => $this->getMockHandler(),
        ]);
    }

    /**
     * Add response
     *
     * @param \GuzzleHttp\Psr7\Response $response
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilderFake
     */
    private function addResponse(Response $response): self
    {
        $this->responses[] = $response;

        return $this;
    }

    /**
     * Get a mock
     *
     * @return \GuzzleHttp\HandlerStack
     */
    private function getMockHandler(): HandlerStack
    {
        return HandlerStack::create(
            new MockHandler(
                [
                    $this->getResponses(),
                ]
            )
        );
    }

    /**
     * Get next response
     *
     * @return Response
     */
    private function getResponses(): Response
    {
        if (count($this->responses) > 0) {
            $response = $this->responses[0];
            $this->responses = array_slice($this->responses, 1);

            return $response;
        }

        return new Response(200, [], '{"foo": "bar"}');
    }
}

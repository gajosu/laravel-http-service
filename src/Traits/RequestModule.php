<?php

namespace Gajosu\LaravelHttpClient\Traits;

use Gajosu\LaravelHttpClient\Contracts\Response;
use Gajosu\LaravelHttpClient\Response\ApiResponse;

trait RequestModule
{
    protected int $request_count = 0;

    /**
     * Get the number of requests that have been made.
     *
     * @return int
     */
    public function getRequestsCount(): int
    {
        return $this->request_count;
    }

    /**
     * Send request or get from cache
     *
     * @return \Gajosu\LaravelHttpClient\Contracts\Response
     */
    protected function sendRequest(): Response
    {
        if ($this->shouldAvoidCache() || null == $this->cache_ttl) {
            return $this->request();
        }

        $cache_key = $this->getCacheKey();
        if ($response = $this->getResponseFromCache($cache_key)) {
            return $response;
        }

        $response = $this->request();
        $this->saveResponseToCache($cache_key, $response);

        return $response;
    }

    /**
     * Send a requests
     *
     * @return \Gajosu\LaravelHttpClient\Response\ApiResponse
     */
    protected function request(): ApiResponse
    {
        $options = [
            'headers' => $this->headers,
        ];

        if (! empty($this->query)) {
            $options['query'] = $this->query;
        }

        if (! empty($this->multipart)) {
            $options['multipart'] = $this->multipart;
        } elseif (! empty($this->body)) {
            $options['json'] = $this->body;
        }

        $response = $this->getClient()->request(
            $this->method,
            $this->path,
            $options
        );

        $this->request_count++;

        return new ApiResponse($response);
    }
}

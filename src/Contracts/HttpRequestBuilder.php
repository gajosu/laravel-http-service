<?php

namespace Gajosu\LaravelHttpClient\Contracts;

use DateTime;
use Gajosu\LaravelHttpClient\Builders\ApiResponse;

interface HttpRequestBuilder
{
    /**
     * Set method
     *
     * @param  string $method
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function setMethod(string $method): self;

    /**
     * Set base uri
     *
     * @param  string $base_uri
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function setBaseUri(string $base_uri): self;

    /**
     * Set path
     *
     * @param string $url
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function setPath(string $path): self;

    /**
     * Set headers
     *
     * @param  array $headers
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function setHeaders(array $headers): self;

    /**
     * Set query string
     *
     * @param  array $query
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function setQuery(array $query): self;

    /**
     * Set multipart
     *
     * @param  array $body
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function setMultipart(string $name, string $contents, string $file_name = null): self;

    /**
     * Set body
     *
     * @param  array $body
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function setBody(array $body): self;

    /**
     * Indicate that the response should be cached
     *
     * @param DateTime|integer|null $seconds
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function cacheFor(DateTime|int|null $seconds): self;

    /**
     * Indicate that the response should be cached forever
     *
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function cacheForever(): self;

    /**
     * Indicate that the response should not be cached
     *
     * @param bool $avoidCache
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function dontCache(bool $avoidCache): self;

    /**
     * Check if the cache operation should be avoided.
     *
     * @return bool
     */
    public function shouldAvoidCache(): bool;

    /**
     * Get response of the request
     *
     * @return \Gajosu\LaravelHttpClient\Builders\ApiResponse
     */
    public function get(): ApiResponse;

    /**
     * Alias for get()
     *
     * @return \Gajosu\LaravelHttpClient\Builders\ApiResponse
     */
    public function send(): ApiResponse;

    /**
     * Get the number of requests that have been made.
     *
     * @return integer
     */
    public function getRequestsCount(): int;
}

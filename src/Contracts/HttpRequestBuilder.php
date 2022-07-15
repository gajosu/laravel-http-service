<?php

namespace Gajosu\LaravelHttpClient\Contracts;

use DateTime;
use Gajosu\LaravelHttpClient\Response\ApiResponse;

interface HttpRequestBuilder
{
    /**
     * Set method
     *
     * @param  string $method
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setMethod(string $method): self;

    /**
     * Set base uri
     *
     * @param  string $base_uri
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setBaseUri(string $base_uri): self;

    /**
     * Set path
     *
     * @param string $path
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setPath(string $path): self;

    /**
     * Set headers
     *
     * @param  array $headers
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setHeaders(array $headers): self;

    /**
     * Set query string
     *
     * @param  array $query
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setQuery(array $query): self;

    /**
     * Set multipart
     *
     * @param  string $name
     * @param  string $contents
     * @param  ?string $file_name
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setMultipart(string $name, string $contents, string $file_name = null): self;

    /**
     * Set body
     *
     * @param  array $body
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setBody(array $body): self;

    /**
     * Indicate that the response should be cached
     *
     * @param DateTime|int|null $seconds
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function cacheFor(DateTime|int|null $seconds): self;

    /**
     * Indicate that the response should be cached forever
     *
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function cacheForever(): self;

    /**
     * Indicate that the response should not be cached
     *
     * @param bool $avoidCache
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
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
     * @return \Gajosu\LaravelHttpClient\Response\ApiResponse
     */
    public function get(): ApiResponse;

    /**
     * Alias for get()
     *
     * @return \Gajosu\LaravelHttpClient\Response\ApiResponse
     */
    public function send(): ApiResponse;

    /**
     * Get the number of requests that have been made.
     *
     * @return int
     */
    public function getRequestsCount(): int;
}

<?php

namespace Gajosu\LaravelHttpClient\Contracts;

use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

interface Response
{
    /**
     * Get the body of the response.
     *
     * @return string
     */
    public function body(): string;

    /**
     * Get the JSON decoded body of the response as an array or scalar value.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function json($key = null, $default = null): mixed;

    /**
     * Get the JSON decoded body of the response as an object.
     *
     * @return object|array
     */
    public function object(): object|array;

    /**
     * Get the JSON decoded body of the response as a collection.
     *
     * @param  string|null  $key
     * @return \Illuminate\Support\Collection
     */

    public function collect($key = null): Collection;
    /**
     * Get a header from the response.
     *
     * @param  string  $header
     * @return string
     */

    public function header(string $header): string;
    /**
     * Get the headers from the response.
     *
     * @return array<array<string>>
     */

    public function headers(): array;
    /**
     * Get the status code of the response.
     *
     * @return int
     */

    public function status(): int;
    /**
     * Get the reason phrase of the response.
     *
     * @return string
     */

    public function reason();

    /**
     * return original response
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getOriginalResponse(): ResponseInterface;
}

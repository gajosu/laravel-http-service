<?php

namespace  Gajosu\LaravelHttpClient\Builders;

use Psr\Http\Message\ResponseInterface;

class ApiResponse
{
    private $response;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(\Psr\Http\Message\ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Return json decoded body
     *
     * @return mixed
     */
    public function jsonDecode(): mixed
    {
        return json_decode($this->response->getBody());
    }

    /**
     * Data attr to collection
     *
     * @return \Illuminate\Support\Collection
     */
    public function toCollect(): \Illuminate\Support\Collection
    {
        return collect($this->jsonDecode());
    }

    /**
     * Return response in string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->response->getBody()->__toString();
    }

    /**
     * return original response
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getOriginalResponse(): ResponseInterface
    {
        return $this->response;
    }
}

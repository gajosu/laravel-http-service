<?php

namespace Gajosu\LaravelHttpClient;

use Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder;
use Gajosu\LaravelHttpClient\Contracts\HttpRequestBuilder;
use Gajosu\LaravelHttpClient\Contracts\Service as ServiceContract;

class HttpService implements ServiceContract
{
    protected HttpRequestBuilder $builder;

    /**
     * Get builder
     *
     * @return \Gajosu\LaravelHttpClient\Contracts\HttpRequestBuilder
     */
    public function getBuilder(): HttpRequestBuilder
    {
        return $this->builder ?? new ApiRequestBuilder();
    }

    /**
     * Set builder
     *
     * @return \Gajosu\LaravelHttpClient\Contracts\Service
     */
    public function setBuilder(HttpRequestBuilder $builder): self
    {
        $this->builder = $builder;
        return $this;
    }
}

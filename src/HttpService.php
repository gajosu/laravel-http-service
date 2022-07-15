<?php

namespace Gajosu\LaravelHttpClient;

use Gajosu\LaravelHttpClient\Contracts\HttpRequestBuilder;
use Gajosu\LaravelHttpClient\Contracts\Service as ServiceContract;
use Gajosu\LaravelHttpClient\Request\ApiRequestBuilder;

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
     * @param \Gajosu\LaravelHttpClient\Contracts\HttpRequestBuilder $builder
     * @return self
     */
    public function setBuilder(HttpRequestBuilder $builder): self
    {
        $this->builder = $builder;

        return $this;
    }
}

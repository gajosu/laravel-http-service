<?php

namespace Gajosu\LaravelHttpClient\Contracts;

interface Service
{
    /**
     * Get builder
     *
     * @return \Gajosu\LaravelHttpClient\Contracts\HttpRequestBuilder
     */
    public function getBuilder(): HttpRequestBuilder;

    /**
     * Set builder
     *
     * @return \Gajosu\LaravelHttpClient\Contracts\Service
     */
    public function setBuilder(HttpRequestBuilder $builder): self;
}

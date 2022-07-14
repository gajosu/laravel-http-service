<?php

namespace Gajosu\LaravelHttpClient\Tests\Fixtures;

use Gajosu\LaravelHttpClient\Contracts\HttpRequestBuilder;
use Gajosu\LaravelHttpClient\HttpService;

class CustomService extends HttpService
{
    public function getBuilder(): HttpRequestBuilder
    {
        return parent::getBuilder()
            ->setHeaders(['X-Custom-Header' => 'Custom-Value']);
    }
}
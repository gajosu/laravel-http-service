<?php

namespace Gajosu\LaravelHttpClient\Tests\Fixtures;

use Gajosu\LaravelHttpClient\Contracts\HttpRequestBuilder;
use Gajosu\LaravelHttpClient\HttpService;

class CustomServiceTwo extends HttpService
{
    public function getBuilder(): HttpRequestBuilder
    {
        return parent::getBuilder()
            ->setHeaders(['Another-Custom-Header' => 'Another-Custom-Value']);
    }
}

<?php

namespace Gajosu\LaravelHttpClient\Tests\Fixtures;

use Gajosu\LaravelHttpClient\Facades\HttpService;

class CustomServiceFacade extends HttpService
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CustomService::class;
    }
}
<?php

namespace Gajosu\LaravelHttpClient\Tests\Fixtures;

use Gajosu\LaravelHttpClient\Facades\HttpService;

class CustomServiceTwoFacade extends HttpService
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CustomServiceTwo::class;
    }
}
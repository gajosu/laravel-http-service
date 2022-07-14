<?php

namespace Gajosu\LaravelHttpClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Gajosu\LaravelHttpClient\LaravelHttpClient
 */
class LaravelHttpClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-http-client';
    }
}

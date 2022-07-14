<?php

namespace Gajosu\LaravelHttpClient\Tests;

use Gajosu\LaravelHttpClient\Tests\TestCase;
use Gajosu\LaravelHttpClient\Facades\LaravelHttpClient;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        LaravelHttpClient::get();
        $this->assertTrue(true);
    }
}
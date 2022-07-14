<?php

namespace Gajosu\LaravelHttpClient\Commands;

use Illuminate\Console\Command;

class LaravelHttpClientCommand extends Command
{
    public $signature = 'laravel-http-client';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

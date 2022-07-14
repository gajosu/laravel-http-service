<?php

namespace Gajosu\LaravelHttpClient;

use Gajosu\LaravelHttpClient\Commands\LaravelHttpClientCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelHttpClientServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-http-client')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-http-client_table')
            ->hasCommand(LaravelHttpClientCommand::class);
    }
}

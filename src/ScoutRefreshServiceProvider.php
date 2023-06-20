<?php

namespace Wasinpwg\ScoutRefresh;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Wasinpwg\ScoutRefresh\Commands\ScoutFreshCommand;
use Wasinpwg\ScoutRefresh\Commands\ScoutRefreshCommand;

class ScoutRefreshServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-scout-refresh')
            ->hasCommand(ScoutRefreshCommand::class)
            ->hasCommand(ScoutFreshCommand::class);
    }
}

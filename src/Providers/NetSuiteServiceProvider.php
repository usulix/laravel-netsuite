<?php

namespace Usulix\NetSuite\Providers;

use Illuminate\Support\ServiceProvider;
use NetSuite\NetSuiteService;
use Usulix\NetSuite\Services\ConfigService;

class NetSuiteServiceProvider extends ServiceProvider
{

    /**
     * Register a singleton binding for 'NetSuiteWebService' directly to the
     * 'NetSuite\NetSuiteService' in the container.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('NetSuiteWebService', static function ($app) {
            return new NetSuiteService((new ConfigService())->getConfig());
        });
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return [
            'NetSuiteWebService'
        ];
    }

}

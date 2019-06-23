<?php

namespace Usulix\NetSuite\Providers;

use Illuminate\Support\ServiceProvider;
use NetSuite\NetSuiteService;
use Usulix\NetSuite\Services\ConfigService;

class NetSuiteServiceProvider extends ServiceProvider
{

    /**
     * Register a singleton binding for 'NetSuiteWebService' in the APP container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('NetSuiteWebService', static function ($app) {
            return new NetSuiteService((new ConfigService())->getWebservicesConfig());
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            'NetSuiteWebService'
        ];
    }

}

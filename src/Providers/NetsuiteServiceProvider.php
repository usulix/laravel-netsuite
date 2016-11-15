<?php namespace Usulix\Netsuite\Providers;

use Usulix\NetSuite\Services\NetSuiteService;
use Usulix\NetSuite\Services\ConfigService;
use Illuminate\Support\ServiceProvider;

class NetsuiteServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Usulix\Netsuite\NetSuiteService', function ($app) {
            return new NetSuiteService((new ConfigService())->getConfig());
        });
    }

    public function provides()
    {
        return ['Usulix\Netsuite\NetSuiteService'];
    }
}

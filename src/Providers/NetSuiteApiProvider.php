<?php namespace Usulix\NetSuite\Providers;

use Monolog\Logger;
use Usulix\NetSuite\Services\NetSuiteApi;
use Usulix\NetSuite\Services\ConfigApiService;
use Illuminate\Support\ServiceProvider;

class NetSuiteApiProvider extends ServiceProvider
{

    protected $defer = true;
    protected $logger;

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->logger = new Logger('name');
        $this->app->singleton('Usulix\NetSuite\NetSuiteApi', function ($app) {
            return new NetSuiteApi($this->logger, (new ConfigApiService($this->logger))->getConfig());
        });
    }

    public function provides()
    {
        return ['Usulix\NetSuite\NetSuiteApi'];
    }
}


<?php namespace Usulix\NetSuite\Providers;

use Usulix\NetSuite\Services\NetSuiteService;
use Usulix\NetSuite\Services\ConfigService;
use Illuminate\Support\ServiceProvider;

class NetSuiteServiceProvider extends ServiceProvider
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
        $this->logger = app('Log');
        $this->app->singleton('Usulix\NetSuite\NetSuiteService', function ($app) {
            return new NetSuiteService($this->logger, (new ConfigService($this->logger))->getConfig());
        });
    }

    public function provides()
    {
        return ['Usulix\NetSuite\NetSuiteService'];
    }
}
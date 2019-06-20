<?php

namespace Usulix\NetSuite\Providers;

use Illuminate\Support\ServiceProvider;
use Usulix\NetSuite\Services\ConfigService;
use Usulix\NetSuite\Services\RestletService;

class NetSuiteApiProvider extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('NetSuiteApiService', static function ($app) {
            return new RestletService((new ConfigService())->getConfig());
        });
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return ['NetSuiteApiService'];
    }

}


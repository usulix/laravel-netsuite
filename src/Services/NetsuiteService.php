<?php namespace Usulix\Netsuite\Services;

use Illuminate\Contracts\Logging\Log;

class NetSuiteService
{

    protected $logger;
    protected $service;

    public function __construct($arrConfig)
    {
        $this->logger = new Log();
        if (!$arrConfig) {
            $this->logger->info('NetSuiteService requested but config not available.');
            return false;
        }
        return new NetSuite\NetsuiteService($arrConfig);
    }
}

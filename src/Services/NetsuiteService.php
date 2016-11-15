<?php namespace Usulix\Netsuite\Services;

use Illuminate\Contracts\Logging\Log;
use NetSuite\NetSuiteService;

class NetsuiteService
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
        return new NetsuiteService($arrConfig);
    }
}

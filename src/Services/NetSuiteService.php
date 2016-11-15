<?php namespace Usulix\NetSuite\Services;

use Illuminate\Contracts\Logging\Log;

class NetSuiteService
{

    protected $logger;
    protected $service;

    public function __construct(Log $log, $arrConfig)
    {
        $this->logger = $log;
        if (!$arrConfig) {
            $this->logger->info('NetSuiteService requested but config not available.');
            return false;
        }
        return new NetSuite\NetsuiteService($arrConfig);
    }
}

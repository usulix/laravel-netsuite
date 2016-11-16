<?php namespace Usulix\NetSuite\Services;

use Usulix\NetSuite\Services\RestletService;

class NetSuiteApi
{
    protected $logger;
    protected $service;

    public function __construct($log, $arrConfig)
    {
        $this->logger = $log;
        if (!$arrConfig) {
            $this->logger->info('NetSuiteService requested but config not available.');
            return false;
        }
        $this->service = new RestletService($arrConfig);
    }

    public function getService()
    {
        return $this->service;
    }
}
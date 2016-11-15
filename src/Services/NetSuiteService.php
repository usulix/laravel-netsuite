<?php namespace Usulix\NetSuite\Services;

class NetSuiteService
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
        return new NetSuite\NetsuiteService($arrConfig);
    }
}

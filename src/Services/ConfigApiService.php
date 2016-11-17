<?php namespace Usulix\NetSuite\Services;

class ConfigApiService
{

    protected $booConfigOk;
    protected $logger;
    protected $arrTokenFields = [
        'NETSUITE_RESTLET_HOST',
        'NETSUITE_ACCOUNT',
        'NETSUITE_CONSUMER_KEY',
        'NETSUITE_CONSUMER_SECRET',
        'NETSUITE_TOKEN',
        'NETSUITE_TOKEN_SECRET'
    ];
    protected $arrNlAuthFields = [
        'NETSUITE_RESTLET_HOST',
        'NETSUITE_ACCOUNT',
        'NETSUITE_EMAIL',
        'NETSUITE_PASSWORD',
        'NETSUITE_ROLE'
    ];

    public function __construct($log)
    {
        $this->booConfigOk = false;
        $this->logger = $log;

        if ($this->checkFields('arrTokenFields') || $this->checkFields('arrNlAuthFields')) {
            $this->booConfigOk = true;
        }

        return $this->booConfigOk;
    }

    public function checkFields($strType)
    {
        foreach ($this->$strType as $strField) {
            if (!getenv($strField)) {
                return false;
            }
        }
        return true;
    }

    public function getConfig()
    {
        if (!$this->booConfigOk) {
            $this->logger->info('Config settings for netsuite service in .env appear to be incomplete');

            return false;
        }
        if (getenv('NETSUITE_PASSWORD')) {
            $arrConfig = [
                'host' => getenv('NETSUITE_RESTLET_HOST'),
                'account' => getenv('NETSUITE_ACCOUNT'),
                'email' => getenv('NETSUITE_EMAIL'),
                'password' => getenv('NETSUITE_PASSWORD'),
                'role' => getenv('NETSUITE_ROLE'),
            ];
        } else {

            $arrConfig = [
                'host' => getenv('NETSUITE_RESTLET_HOST'),
                'account' => getenv('NETSUITE_ACCOUNT'),
                'consumerKey' => getenv('NETSUITE_CONSUMER_KEY'),
                'consumerSecret' => getenv('NETSUITE_CONSUMER_SECRET'),
                'token' => getenv('NETSUITE_TOKEN'),
                'tokenSecret' => getenv('NETSUITE_TOKEN_SECRET')
            ];
            if (getenv('NETSUITE_SIGNATURE_ALGORITHM')) {
                $arrConfig['signatureAlgorithm'] = getenv('NETSUITE_SIGNATURE_ALGORITHM');
            } else {
                $arrConfig['signatureAlgorithm'] = 'HMAC-SHA256';
            }
        }
        if (getenv('NETSUITE_LOGGING')) {
            $arrConfig['logging'] = getenv('NETSUITE_LOGGING');
        }
        if (getenv('NETSUITE_LOG_PATH')) {
            $arrConfig['log_path'] = getenv('NETSUITE_LOG_PATH');
        }
        return $arrConfig;
    }
}

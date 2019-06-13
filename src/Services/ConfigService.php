<?php

namespace Usulix\NetSuite\Services;

class ConfigService
{

    /*
     *
     */
    public function __construct()
    {
    }

    /**
     * Get the current config from the ENV
     *
     * @return array
     */
    public function getConfig(): array
    {
        $config = array(
            'endpoint' => getenv('NETSUITE_ENDPOINT') ?: '2016_1',
            'host' => getenv('NETSUITE_HOST'),
            'email' => getenv('NETSUITE_EMAIL'),
            'password' => getenv('NETSUITE_PASSWORD'),
            'role' => getenv('NETSUITE_ROLE'),
            'account' => getenv('NETSUITE_ACCOUNT'),
            'consumerKey' => getenv('NETSUITE_CONSUMER_KEY'),
            'consumerSecret' => getenv('NETSUITE_CONSUMER_SECRET'),
            'token' => getenv('NETSUITE_TOKEN'),
            'tokenSecret' => getenv('NETSUITE_TOKEN_SECRET'),
            'app_id' => getenv('NETSUITE_APP_ID'),
            'logging' => getenv('NETSUITE_LOGGING'),
            'log_path' => getenv('NETSUITE_LOG_PATH'),
            'signatureAlgorithm' => getenv('NETSUITE_HASH_TYPE') ?: 'sha256'
        );
        return $config;
    }

}

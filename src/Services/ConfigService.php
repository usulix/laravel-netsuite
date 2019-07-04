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

  private function getEnvConfig()
    {
        $config = array(
            'endpoint' => getenv('NETSUITE_ENDPOINT') ?: '2016_1',
            'host_webservices' => getenv('NETSUITE_WEBSERVICES_HOST'),
            'host_restlet' => getenv('NETSUITE_RESTLET_HOST'),
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
            'signatureAlgorithm' => getenv('NETSUITE_HASH_TYPE') ?: 'sha256',
        );
        return $config;
    }

    /**
     * Return the Restlet config array
     *
     * @return array
     */
    public function getRestletConfig()
    {
        // Grab all the current ENV settings
        $envConfig = $this->getEnvConfig();
        // Check to see if 'host_restlet' is set else use new account specific URL
        if (!empty($envConfig['host_restlet'])) {
            $envConfig['host'] = $envConfig['host_restlet'];
        } else {
            // Detail auto url from account name
            $envConfig['host'] = 'https://'.$envConfig['account'].'.restlets.api.netsuite.com'.'/app/site/hosting/restlet.nl';
        }
        // Remove other hosts before returning, in case of future clashes
        unset($envConfig['host_restlet'], $envConfig['host_webservices']);
        return $$envConfig;
    }

    /**
     * Return the Web Services config array
     *
     * @return array
     */
    public function getWebservicesConfig()
    {
        // Grab all the current ENV settings
        $envConfig = $this->getEnvConfig();
        // Check to see if 'host_restlet' is set else use new account specific URL
        if (!empty($envConfig['host_webservices'])) {
            $envConfig['host'] = $envConfig['host_webservices'];
        } else {
            // Detail auto url from account name
            $envConfig['host'] = 'https://'.$envConfig['account'].'.suitetalk.api.netsuite.com';
        }
        // Remove other hosts before returning, in case of future clashes
        unset($envConfig['host_restlet'], $envConfig['host_webservices']);
        return $envConfig;
    }

}

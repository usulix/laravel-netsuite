<?php namespace Usulix\Netsuite\Services;

use Illuminate\Contracts\Logging\Log;

class ConfigService
{

    protected $booConfigOk;
    protected $logger;
    protected $arrNlAuthFields;
    protected $arrTokenFields;

    public function __construct()
    {
        $this->booConfigOk = false;
        $this->logger = new Log();
        $this->arrTokenFields = [
            'NETSUITE_ENDPOINT',
            'NETSUITE_HOST',
            'NETSUITE_ACCOUNT',
            'NETSUITE_CONSUMER_KEY',
            'NETSUITE_CONSUMER_SECRET',
            'NETSUITE_TOKEN',
            'NETSUITE_TOKEN_SECRET',
        ];
        $this->arrNlAuthFields = [
            'NETSUITE_ENDPOINT',
            'NETSUITE_HOST',
            'NETSUITE_ACCOUNT',
            'NETSUITE_EMAIL',
            'NETSUITE_PASSWORD',
            'NETSUITE_ROLE',
            'NETSUITE_APP_ID',
        ];
        if ($this->checkToken() || $this->checkAuth()) {
            $this->booConfigOk = true;
        }

        return $this->booConfigOk;
    }

    public function getConfig()
    {
        if (!$this->booConfigOk) {
            $this->logger->info('Config settings for netsuite service in .env appear to be incomplete');

            return false;
        }
        if (getenv('NETSUITE_PASSWORD')) {
            $arrConfig = [
                'endpoint' => getenv('NETSUITE_ENDPOINT'),
                'host' => getenv('NETSUITE_HOST'),
                'account' => getenv('NETSUITE_ACCOUNT'),
                'email' => getenv('NETSUITE_EMAIL'),
                'password' => getenv('NETSUITE_PASSWORD'),
                'role' => getenv('NETSUITE_ROLE'),
                'app_id' => getenv('NETSUITE_APP_ID')
            ];
        } else {

            $arrConfig = [
                'endpoint' => getenv('NETSUITE_ENDPOINT'),
                'host' => getenv('NETSUITE_HOST'),
                'account' => getenv('NETSUITE_ACCOUNT'),
                'consumerKey' => getenv('NETSUITE_CONSUMER_KEY'),
                'consumerSecret' => getenv('NETSUITE_CONSUMER_SECRET'),
                'token' => getenv('NETSUITE_TOKEN'),
                'tokenSecret' => getenv('NETSUITE_TOKEN_SECRET')
            ];
            if (getenv('NETSUITE_SIGNATURE_ALGORITHM')) {
                $arrConfig['signatureAlgorithm'] = getenv('NETSUITE_SIGNATURE_ALGORITHM');
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

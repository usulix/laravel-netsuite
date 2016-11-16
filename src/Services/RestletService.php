<?php namespace Usulix\NetSuite\Services;

use GuzzleHttp\Client;

class RestletService
{
    protected $arrConfig, $arrData, $strScriptId;

    /**
     * @return mixed
     */
    public function getArrConfig()
    {
        return $this->arrConfig;
    }

    /**
     * @param mixed $arrConfig
     */
    public function setArrConfig($arrConfig)
    {
        $this->arrConfig = $arrConfig;
    }

    /**
     * @return mixed
     */
    public function getArrData()
    {
        return $this->arrData;
    }

    /**
     * @param mixed $arrData
     */
    public function setArrData($arrData)
    {
        $this->arrData = $arrData;
    }

    /**
     * @return mixed
     */
    public function getStrScriptId()
    {
        return $this->strScriptId;
    }

    /**
     * @param mixed $strScriptId
     */
    public function setStrScriptId($strScriptId)
    {
        $this->strScriptId = $strScriptId;
    }

    /**
     * @return boolean
     */
    public function isBooUsingTokenAuth()
    {
        return $this->booUsingTokenAuth;
    }

    /**
     * @param boolean $booUsingTokenAuth
     */
    public function setBooUsingTokenAuth($booUsingTokenAuth)
    {
        $this->booUsingTokenAuth = $booUsingTokenAuth;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param mixed $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return mixed
     */
    public function getNlauth()
    {
        return $this->nlauth;
    }

    /**
     * @param mixed $nlauth
     */
    public function setNlauth($nlauth)
    {
        $this->nlauth = $nlauth;
    }

    /**
     * @return array
     */
    public function getNlauthHeaders()
    {
        return $this->nlauthHeaders;
    }

    /**
     * @param array $nlauthHeaders
     */
    public function setNlauthHeaders($nlauthHeaders)
    {
        $this->setNlauthHeaders($nlauthHeaders);
    }

    protected $booUsingTokenAuth = false;
    protected $method = 'POST';
    protected $baseUrl;
    protected $nlauth;
    protected $nlauthHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'Cache-Control' => 'no-cache',
        'Pragma' => 'no-cache'
    ];

    public function __construct($arrConfig)
    {
        $this->setArrConfig($arrConfig);

        if (array_key_exists('password', $arrConfig)) {
            $this->configNlAuth();
        } else {
            $this->configToken();
            $this->setBooUsingTokenAuth(true);
        }
    }

    public function configNlAuth()
    {
        $this->setBaseUrl($this->arrConfig['host'] . '?deploy=1&script=');
        $this->setNlauth('NLAuth nlauth_account=' . $this->arrConfig['account'] . ',nlauth_email=' .
            $this->arrConfig['email'] . ',nlauth_signature=' . $this->arrConfig['password'] . ',nlauth_role=' .
            $this->arrConfig['role']);
    }

    public function getNetSuiteData($strScriptId, $arrData = [])
    {
        $this->setStrScriptId($strScriptId);
        $this->setArrData($arrData);
        if ($this->booUsingTokenAuth) {
            return $this->callWithToken();
        }
        return $this->callWithNlAuth();
    }

    public function callWithNlAuth()
    {
        $this->setBaseUrl($this->getBaseUrl() . $this->getStrScriptId());
        $headers = $this->getNlauthHeaders();
        $headers['Content-length'] = strlen(json_encode($this->getArrData()));
        $headers['Authorization'] = $this->getNlauth();
        $response = (new Client())->request($this->getMethod(), $this->getBaseUrl(), [
            'headers' => $headers,
            'json' => $this->getArrData()
        ]);
        $b = json_decode($response->getBody(), true);
        return $b;
    }
}
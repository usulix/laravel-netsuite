<?php namespace Usulix\NetSuite\Models;

class Oauth
{
    protected $oauth_nonce, $oauth_timestamp, $oauth_signature_method, $oauth_version;
    protected $url, $arrConfig, $strScriptId, $strMethod;
    protected $baseString, $signatureString, $oauthSignature, $oauthHeader;

    /**
     * @return string
     */
    public function getOauthNonce()
    {
        return $this->oauth_nonce;
    }

    /**
     * @param string $oauth_nonce
     */
    public function setOauthNonce($oauth_nonce)
    {
        $this->oauth_nonce = $oauth_nonce;
    }

    /**
     * @return int
     */
    public function getOauthTimestamp()
    {
        return $this->oauth_timestamp;
    }

    /**
     * @param int $oauth_timestamp
     */
    public function setOauthTimestamp($oauth_timestamp)
    {
        $this->oauth_timestamp = $oauth_timestamp;
    }

    /**
     * @return string
     */
    public function getOauthSignatureMethod()
    {
        return $this->oauth_signature_method;
    }

    /**
     * @param string $oauth_signature_method
     */
    public function setOauthSignatureMethod($oauth_signature_method)
    {
        $this->oauth_signature_method = $oauth_signature_method;
    }

    /**
     * @return string
     */
    public function getOauthVersion()
    {
        return $this->oauth_version;
    }

    /**
     * @param string $oauth_version
     */
    public function setOauthVersion($oauth_version)
    {
        $this->oauth_version = $oauth_version;
    }

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
     * @return mixed
     */
    public function getStrMethod()
    {
        return $this->strMethod;
    }

    /**
     * @param mixed $strMethod
     */
    public function setStrMethod($strMethod)
    {
        $this->strMethod = $strMethod;
    }

    /**
     * @return mixed
     */
    public function getOauthHeader()
    {
        return $this->oauthHeader;
    }

    public function __construct($arrConfig, $strScriptId, $strMethod)
    {
        $this->setOauthNonce(md5(mt_rand()));
        $this->setOauthTimestamp(time());
        $this->setOauthVersion("1.0");
        $this->setArrConfig($arrConfig);
        $this->setStrScriptId($strScriptId);
        $sigMeth = array_key_exists('signatureAlgorithm', $arrConfig) ? $arrConfig['signatureAlgorithm'] : 'HMAC-SHA256';
        $this->setOauthSignatureMethod($sigMeth);
        $this->setStrMethod($strMethod);

        $this->setBaseString();
        $this->setSignatureString();
        $this->setOauthSignature();
        $this->setOauthHeader();

    }

    public function setBaseString()
    {
        $this->baseString=$this->getStrMethod()."&" . urlencode($this->getArrConfig()['host']) . "&" .
            urlencode("deploy=1"
                . "&oauth_consumer_key=" . $this->getArrConfig()['consumerKey']
                . "&oauth_nonce=" . $this->getOauthNonce()
                . "&oauth_signature_method=" . $this->getOauthSignatureMethod()
                . "&oauth_timestamp=" . $this->getOauthTimestamp()
                . "&oauth_token=" . $this->getArrConfig()['token']
                . "&oauth_version=" . $this->getOauthVersion()
                . "&realm=" . $this->getArrConfig()['account']
                . "&script=" . $this->getStrScriptId()
            );
    }

    public function setSignatureString()
    {
        $this->signatureString = urlencode($this->getArrConfig()['consumerSecret']).
            '&'.urlencode($this->getArrConfig()['tokenSecret']);
    }

    public function setOauthSignature()
    {
        $hash = 'sha256';
        if($this->getArrConfig()['signatureAlgorithm']!=='HMAC-SHA256'){
            $hash = 'sha1';
        }
        $this->oauthSignature = base64_encode(hash_hmac($hash, $this->baseString, $this->signatureString, true));
    }

    public function setOauthHeader()
    {
        $this->oauthHeader = "OAuth "
            . 'oauth_signature="' . rawurlencode($this->oauthSignature) . '", '
            . 'oauth_version="' . rawurlencode($this->getOauthVersion()) . '", '
            . 'oauth_nonce="' . rawurlencode($this->getOauthNonce()) . '", '
            . 'oauth_signature_method="' . rawurlencode($this->getArrConfig()['signatureAlgorithm']) . '", '
            . 'oauth_consumer_key="' . rawurlencode($this->getArrConfig()['consumerKey']) . '", '
            . 'oauth_token="' . rawurlencode($this->getArrConfig()['token']) . '", '
            . 'oauth_timestamp="' . rawurlencode($this->getOauthTimestamp()) . '", '
            . 'realm="' . rawurlencode($this->getArrConfig()['account']) .'"';
    }
}
<?php
namespace riskivy\rsa;

use yii\base\Component;
use Yii;

class RSA extends Component implements ISecurityProvider
{
    public $services;
    public $provider = 'OpensslRSA';
    public $publicKey = null;
    public $privateKey = null;

    private $_securityProvider = null;

    public function init()
    {
        if (count($this->services) == 0) {
            \Yii::error('No ISecurityProvider configured');
            throw new \Exception('No ISecurityProvider configured');
            return false;
        }

        $provider = $this->provider;
        if ($provider === null) {
            $provider = array_keys($this->services)[0];
        }
        // my use other provider like: https://github.com/jedisct1/libsodium-php
        $this->provider = $provider;
        $this->setProvider(Yii::createObject($this->services[$provider]));
        $this->setPrivateKeyFile($this->privateKey);
        $this->setPublicKeyFile($this->publicKey);
    }

    public function setProvider(ISecurityProvider $sp)
    {
        if ($sp instanceof ISecurityProvider) {
            $this->_securityProvider = $sp;
        } else {
            throw new \Exception('invalid ISecurityProvider.');
        }
    }

    public function setPublicKeyFile($pubKey)
    {
        $this->_securityProvider->setPublicKeyFile($pubKey);
    }

    public function setPrivateKeyFile($privateKey, $passphrase = "")
    {
        $this->_securityProvider->setPrivateKeyFile($privateKey, $passphrase);
    }

    public function privateEncrypt($dataToEncrypt)
    {
        $this->setPrivateKeyFile($this->privateKey);
        return $this->_securityProvider->privateEncrypt($dataToEncrypt);
    }

    public function privateDecrypt($dataToDecrypt)
    {
        $this->setPrivateKeyFile($this->privateKey);
        return $this->_securityProvider->privateDecrypt($dataToDecrypt);
    }

    public function publicEncrypt($dataToEncrypt)
    {
        $this->setPublicKeyFile($this->publicKey);
        return $this->_securityProvider->publicEncrypt($dataToEncrypt);
    }

    public function publicDecrypt($dataToDecrypt)
    {
        $this->setPublicKeyFile($this->publicKey);
        return $this->_securityProvider->publicDecrypt($dataToDecrypt);
    }

    public function sign($data, $signatureAlg = 'sha1')
    {
        $this->setPrivateKeyFile($this->privateKey);
        return $this->_securityProvider->sign($data, $signatureAlg);
    }

    public function verify($data, $signature, $signatureAlg = 'sha1')
    {
        $this->setPublicKeyFile($this->publicKey);
         return $this->_securityProvider->verify($data, $signature, $signatureAlg);
    }
}//end class

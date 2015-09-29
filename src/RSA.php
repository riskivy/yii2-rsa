<?php
/*=============================================================================
#     FileName: RSA.php
#         Desc:
#       Author: 荒野无灯
#      Version: 0.0.1
#   LastChange: 2014-07-02 18:39:25
#      History:
#       Usage:
`php
demo1:
     发送:商户私钥签名,接口平台公钥加密
     接收:接口平台公钥验签，使用商户私钥解密
     因此在商户这里只需要用到商户私钥+接口平台公钥

    public function initSecurity()
    {
        $privateKey =  '/data/platform/' . $this->_configProvider->getMerPrivateKey();
        $platformPubkey =  '/data/platform/' . $this->_configProvider->getplatformPublicKey();
        $rsa = new RSA();
        $rsa->addProvider(new OpensslRSA());
        $rsa->setPrivateKeyFile($privateKey);
        $rsa->setPublicKeyFile($platformPubkey);
        $this->_rsa = $rsa;
    }
``
=============================================================================*/

namespace \ihacklog\rsa;

class RSA implements ISecurityProvider
{
    private $_securityProvider = null;

    public function addProvider(ISecurityProvider $sp)
    {
        if ($sp instanceof ISecurityProvider) {
            $this->_securityProvider = $sp;
        } else {
            throw new Exception('invalid ISecurityProvider.');
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
        return $this->_securityProvider->privateEncrypt($dataToEncrypt);
    }

    public function privateDecrypt($dataToDecrypt)
    {
        return $this->_securityProvider->privateDecrypt($dataToDecrypt);
    }

    public function publicEncrypt($dataToEncrypt)
    {
        return $this->_securityProvider->publicEncrypt($dataToEncrypt);
    }

    public function publicDecrypt($dataToDecrypt)
    {
        return $this->_securityProvider->publicDecrypt($dataToDecrypt);
    }

    public function sign($data, $signatureAlg = 'sha1')
    {
        return $this->_securityProvider->sign($data, $signatureAlg);
    }

    public function verify($data, $signature, $signatureAlg = 'sha1')
    {
         return $this->_securityProvider->verify($data, $signature, $signatureAlg);
    }
}//end class

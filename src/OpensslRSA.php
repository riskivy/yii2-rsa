<?php
/*=============================================================================
#     FileName: RSA.php
#         Desc:
#       Author: 荒野无灯
#      Version: 0.0.1
#   LastChange: 2014-07-02 16:05:24
#      History:
=============================================================================*/

namespace ihacklog\rsa;

use yii\base\Component;

class OpensslRSA extends Component implements ISecurityProvider
{
    private $_privateKey = '';

    private $_publicKey  = '';

    /**
     * export(openssl_get_md_methods());
        array (
        0 => 'DSA',
        1 => 'DSA-SHA',
        2 => 'MD4',
        3 => 'MD5',
        4 => 'MDC2',
        5 => 'RIPEMD160',
        6 => 'SHA',
        7 => 'SHA1',
        8 => 'SHA224',
        9 => 'SHA256',
        10 => 'SHA384',
        11 => 'SHA512',
        12 => 'dsaEncryption',
        13 => 'dsaWithSHA',
        14 => 'ecdsa-with-SHA1',
        15 => 'md4',
        16 => 'md5',
        17 => 'mdc2',
        18 => 'ripemd160',
        19 => 'sha',
        20 => 'sha1',
        21 => 'sha224',
        22 => 'sha256',
        23 => 'sha384',
        24 => 'sha512',
        25 => 'whirlpool',
        )
     *
     * @var array
     */

    /**
     * get digest method
     *
     * @param mixed $sigAlgo
     * @return void
     */
    private function getDigestMethod($sigAlgo)
    {
        if (!in_array($sigAlgo, openssl_get_md_methods())) {
            throw new Exception('invalid signature algo!');
        }
        return $sigAlgo;
    }

    public function setPublicKeyFile($pubKey)
    {
        if (!(strpos($pubKey, '-----BEGIN PUBLIC KEY-----') === 0)) {
            if (!is_readable($pubKey)) {
                throw new Exception(sprintf('publickey file : %s is not readable!', $pubKey));
            }
            $pubKeyStr = file_get_contents($pubKey);
        } else {
            $pubKeyStr = $pubKey;
        }
        $this->_publicKey = openssl_pkey_get_public($pubKeyStr);
    }

    public function setPrivateKeyFile($privateKey, $passphrase = "")
    {
        if (!(strpos($privateKey, '-----BEGIN RSA PRIVATE KEY-----') === 0)) {
            if (!is_readable($privateKey)) {
                throw new Exception(sprintf('privatekey file : %s is not readable!', $privateKey));
            }
            $privateKeyStr = file_get_contents($privateKey);
        } else {
            $privateKeyStr = $privateKey;
        }
        $this->_privateKey = openssl_pkey_get_private($privateKeyStr, $passphrase);
    }

    public function privateEncrypt($dataToEncrypt)
    {
        $encryptedText = '';
        openssl_private_encrypt($dataToEncrypt, $encryptedText, $this->_privateKey);
        //openssl_error_string() === false;
        return $encryptedText;
    }

    public function privateDecrypt($dataToDecrypt)
    {
        $decryptText = '';
        openssl_private_decrypt($dataToDecrypt, $decryptText, $this->_privateKey);
        return $decryptText;
    }

    public function publicEncrypt($dataToEncrypt)
    {
        $encryptedText = '';
        openssl_public_encrypt($dataToEncrypt, $encryptedText, $this->_publicKey);
        return $encryptedText;
    }

    public function publicDecrypt($dataToDecrypt)
    {
        $decryptText = '';
        openssl_public_decrypt($dataToDecrypt, $decryptText, $this->_publicKey);
        return $decryptText;
    }

    /**
     * 私钥签名 (SHA1withRSA算法)
     *
     * @return string
     */
    public function sign($data, $signatureAlg = 'sha1')
    {
        $signature = '';
        openssl_sign($data, $signature, $this->_privateKey, $this->getDigestMethod($signatureAlg));
        return $signature;
    }

    /**
     * 公钥验签 (SHA1withRSA算法)
     *
     * @return bool
     */
    public function verify($data, $signature, $signatureAlg = 'sha1')
    {
        $verifyResult = openssl_verify($data, $signature, $this->_publicKey, $this->getDigestMethod($signatureAlg));
        if ($verifyResult === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function __destruct()
    {
        is_resource($this->_privateKey) && openssl_free_key($this->_privateKey);
        is_resource($this->_publicKey) && openssl_free_key($this->_publicKey);
    }
}//end class

<?php

namespace riskivy\rsa;

interface ISecurityProvider
{
    public function setPublicKeyFile($pubKey);

    public function setPrivateKeyFile($privateKey, $passphrase = "");

    public function privateEncrypt($dataToEncrypt);

    public function privateDecrypt($dataToDecrypt);

    public function publicEncrypt($dataToEncrypt);

    public function publicDecrypt($dataToDecrypt);

    public function sign($data, $signatureAlg = 'sha1');

    public function verify($data, $signature, $signatureAlg = 'sha1');
}

<?php
/*=============================================================================
#     FileName: ISecurity.php
#         Desc:
#       Author: 荒野无灯
#   LastChange: 2014-07-02 18:33:11
#      History:
=============================================================================*/

namespace ihacklog\rsa;

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

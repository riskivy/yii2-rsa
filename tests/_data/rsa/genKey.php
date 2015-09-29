#!/usr/bin/env php
<?php
/**
 * Short description for genKey.php
 *
 * @package genKey
 * @author sh4d0walker <sh4d0walker@Sh4d0Walker-Arch-work>
 * @version 0.1
 * @copyright (C) 2015 sh4d0walker <sh4d0walker@Sh4d0Walker-Arch-work>
 * @license MIT
 */

function genTestKeyPair($pkeyFile = 'merPriateKey.perm', $pubKeyFile = 'merPubKey.perm')
{
    echo " ==== Start. ====\n";
    $res = openssl_pkey_new();
    $pkey = '';
    openssl_pkey_export($res, $pkey);
    file_put_contents($pkeyFile, $pkey);
    echo "output private key to : $pkeyFile\n";
    $pubkey = openssl_pkey_get_details($res);
    $pubkeyStr = $pubkey['key'];
    file_put_contents($pubKeyFile, $pubkeyStr);
    echo "output public key to : $pubKeyFile\n";
    echo " ==== Done. ====\n";
}

genTestKeyPair();
genTestKeyPair('platformPriateKey.perm', 'platformPubKey.perm');

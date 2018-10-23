yii2-rsa
========
YII2 openssl rsa 加密 签名

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

First run

```
composer require riskivy/yii2-rsa
```

Usage
-----
components 

        'rsa' => [
            'class' => 'riskivy\rsa\RSA',
            'publicKey' => 'path/to/publicKey.pem',
            'privateKey' => 'path/to/privateKey.pem',
            'services' => [
                'OpensslRSA' => [
                    'class' => riskivy\rsa\OpensslRSA::class,
                ]
            ]
        ],
        
Once the extension is installed, simply use it in your code by  :

```php

        //use file path
        $publicKey = Yii::$app->rsa->publicKey;
        $privateKey = Yii::$app->rsa->privateKey;

        //use file content
//        $publicKey = <<<EOF
//-----BEGIN RSA PRIVATE KEY-----
//xxxxxxxxx
//-----END RSA PRIVATE KEY-----
//EOF;
//        $publicKey = <<<EOF
//-----BEGIN PUBLIC KEY-----
//xxxxxxxxx
//-----END PUBLIC KEY-----
//EOF;

        try{
            $rsa       = new RSA();
            $rsa->addProvider(new OpensslRSA());
            $rsa->setPublicKeyFile($publicKey);
            $rsa->setPrivateKeyFile($privateKey);

            $s1= $rsa->publicEncrypt('bar');
            var_dump(base64_encode($s1));
            var_dump($rsa->privateDecrypt($s1));

        }catch(\Exception $e){

            var_dump($e->getMessage());die;
        }


```


Get rsa_private_key and rsa_public_key

-----------------------

```bash
openssl genrsa -out rsa_private_key.pem 512
openssl rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem
```

yii2-rsa
========
YII2 openssl rsa 加密 签名

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

First you need add this to your `composer.json` file:
```json
{
  "repositories": [
    {
      "type": "git",
      "url": "git@github.com:riskivy/yii2-rsa.git"
    }
  ],
}
```

Then, either run

```
composer require riskivy/yii2-rsa
```

or add
```
"ihacklog/yii2-rsa": "*@dev"
```

to the `require` section of your `composer.json` file.


Usage
-----
components 

        'rsa' => [
            'class' => 'ihacklog\rsa\RSA',
            'publicKey' => $vendorDir . '/ihacklog/yii2-rsa/tests/_data/rsa/p2p20140616.cer',
            'privateKey' => $vendorDir . '/ihacklog/yii2-rsa/tests/_data/rsa/p2p20140616.pem',
            'services' => [
                'OpensslRSA' => [
                    'class' => ihacklog\rsa\OpensslRSA::class,
                ]
            ]
        ],
        
Once the extension is installed, simply use it in your code by  :

```php
<?php
        $publicKey = Yii::$app->rsa->publicKey;
        $privateKey = Yii::$app->rsa->privateKey;
        
        $rsa       = new RSA();
        $rsa->addProvider(new OpensslRSA());
        $rsa->setPublicKeyFile($publicKey);
        $rsa->setPrivateKeyFile($privateKey);
        
        $s1= $rsa->publicEncrypt('bar');  
        echo $rsa->privateDecrypt($s1);   

```


Tests
-----
```bash
cd vendor/ihacklog/yii2-rsa
codecept run
```

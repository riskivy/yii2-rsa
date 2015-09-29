yii2-rsa
========
yii2 rsa lib

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist ihacklog/yii2-rsa "*"
```

or add

```
"ihacklog/yii2-rsa": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?php
        $privateKey =  '/_data/rsa/merPkey.pem';
        $pubkey =  '/_data/rsa/merPubKey.pem';
        $rsa = new RSA();
        $rsa->addProvider(new OpensslRSA());
        $rsa->setPrivateKeyFile($privateKey);
        $rsa->setPublicKeyFile($pubkey);
        var_dump($rsa->privateDecrypt($rsa->publicEncrypt('bar')));
```
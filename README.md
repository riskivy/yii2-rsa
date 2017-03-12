yii2-rsa
========
yii2 rsa lib demoxxx

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

First you need add this to your `composer.json` file:
```json
{
  "repositories": [
    {
      "type": "git",
      "url": "git@github.com:ihacklog/yii2-rsa.git"
    }
  ],
}
```

Then, either run

```
php composer.phar require --prefer-dist ihacklog/yii2-rsa "*"
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
        var_dump($rsa->privateDecrypt($rsa->publicEncrypt('bar')));
        
#正确的方法 

           $s1= \Yii::$app->rsa->publicEncrypt('bar');  
           echo \Yii::$app->rsa->privateDecrypt($s1);   

```


Tests
-----
```bash
cd vendor/ihacklog/yii2-rsa
codecept run
```

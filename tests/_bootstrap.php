<?php
// This is global bootstrap for autoloading

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

$yiiBasePath = __DIR__ . '/../';
require_once($yiiBasePath . '/vendor/autoload.php');
require_once($yiiBasePath . '/vendor/yiisoft/yii2/Yii.php');

Yii::setAlias('@tests', __DIR__);
Yii::setAlias('@ihacklog/rsa', __DIR__ . '/../src/');

new \yii\console\Application([
    'id' => 'unit',
    'basePath' => $yiiBasePath,
    'aliases' => [
        '@ihacklog/rsa' => __DIR__ . '/../src/',
    ],
    'components' => [
        'rsa' => [
            'class' => 'ihacklog\rsa\RSA',
            'publicKey' => Yii::getAlias('@tests') . '/_data/rsa/p2p20140616.cer',
            'privateKey' => Yii::getAlias('@tests') . '/_data/rsa/p2p20140616.pem',
            'services' => [
                'OpensslRSA' => [
                    'class' => 'ihacklog\rsa\OpensslRSA',
                ]
            ]
        ]
    ]
]);
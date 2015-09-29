<?php
// This is global bootstrap for autoloading

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

$yiiBasePath = __DIR__ . '/../../../..';
require_once($yiiBasePath . '/vendor/autoload.php');
require_once($yiiBasePath . '/vendor/yiisoft/yii2/Yii.php');

Yii::setAlias('@tests', __DIR__);

new \yii\console\Application([
    'id' => 'unit',
    'basePath' => $yiiBasePath,
]);
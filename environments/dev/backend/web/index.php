<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$domainParamsCommon = [];
$domainParamsLocal = [];

if (file_exists(__DIR__ . '/../../common/config/domainParams/'.$_SERVER['HTTP_HOST'].'.php')) {
    $domainParamsCommon = require __DIR__ . '/../../common/config/domainParams/'.$_SERVER['HTTP_HOST'].'.php';
}
if (file_exists(__DIR__ . '/../config/domainParams/'.$_SERVER['HTTP_HOST'].'.php')) {
    $domainParamsLocal = require __DIR__ . '/../config/domainParams/'.$_SERVER['HTTP_HOST'].'.php';
}


require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

$params = array_replace_recursive(
    require __DIR__ . '/../../common/config/core/params.php',
    require __DIR__ . '/../config/core/params.php',
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/../config/params-local.php',
    $domainParamsCommon,
    $domainParamsLocal
);

$config = array_replace_recursive(
    require __DIR__ . '/../../common/config/core/main.php',
    require __DIR__ . '/../config/core/main.php',
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../config/main-local.php'
);

(new yii\web\Application($config))->run();
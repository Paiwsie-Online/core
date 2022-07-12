<?php
$defaultParams = require __DIR__.'/params.php';
if (file_exists(__DIR__.'/domainParams/'.$_SERVER['HTTP_HOST'].'.php')) {
    $domainParams = require __DIR__.'/domainParams/'.$_SERVER['HTTP_HOST'].'.php';
}
if (isset($domainParams) && is_array($domainParams)) {
    $params = array_replace_recursive($defaultParams, $domainParams);
} else {
    $params = $defaultParams;
}

$db = array_replace_recursive($params['db'], $params['test_db']);

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'db' => $db,
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'user' => [
            'identityClass' => 'common\models\core\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => $params,
];

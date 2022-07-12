<?php

/** @var $params */

return [
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'controllerMap' => [
        // PUT HERE YOUR CUSTOM CONTROLLER THAT EXTENDS THE ONES IN THE CORE
        //'site' => 'backend\controllers\core\SiteController',
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\core\User',
            'enableAutoLogin' => false,
            'authTimeout' => $params['systemTimeout']['authTimeout'],
            'enableSession' => true,
            'autoRenewCookie' => false,
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true
            ],
        ],
    ],
    'layout' => $params['layout']['main']
];
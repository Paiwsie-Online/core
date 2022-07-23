<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/

/** @var $params */

use yii\rest\UrlRule;
use yii\web\JsonParser;

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerMap' => [
        'active' => 'api\controllers\core\ActiveController',
        'api-key' => 'api\controllers\core\ApiKeyController',
        'enumeration' => 'api\controllers\core\EnumerationController',
        'graphdata' => 'api\controllers\core\GraphdataController',
        'uploadfile' => 'api\controllers\core\UploadfileController',
        'user' => 'api\controllers\core\UserController',
        'user-detail' => 'api\controllers\core\UserDetailController',
        'user-setting' => 'api\controllers\core\UserSettingController',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'change_now_your_validation_key',
            'csrfParam' => '_csrfapi',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => JsonParser::class,
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\core\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'baseController' => [
            'class' => 'backend\components\core\BaseController'
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
        ],
        'uiComponent' => [
            'class' =>  'backend\components\core\uiComponents',
        ],
        'sms' => [
            'class' =>  'backend\components\core\sms',
        ],
        'guides' => [
            'class' =>  'backend\components\core\guides',
        ],
        'makeGraphics' => [
            'class' =>  'backend\components\core\makeGraphics',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'translatemanager' => [
            'class' => 'lajax\translatemanager\Component'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'name' => 'advanced-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => UrlRule::class,
                    'controller' => ['users' => 'user', 'user-detail', 'user-setting', 'enumeration', 'graphdata', 'uploadfile'],
                ],
                'users/login' => 'user/login',
                'users/register' => 'user/register',
                'users/forgotpw' => 'user/forgotpw',
                'users/resend-code' => 'user/resend-code',
                'users/email-verify' => 'user/email-verify',
                'users/forgot-password-verify' => 'user/forgot-password-verify',
            ],
        ],
        'thumbnailer' => [
            'class' => 'daxslab\thumbnailer\Thumbnailer',
            'defaultWidth' => 500,
            'defaultHeight' => 500,
            'thumbnailsBaseUrl' => '@web/assets/thumbnails',
            'enableCaching' => true, //defaults to false but is recommended
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $params['SmtpSettings']['host'],
                'username' => $params['SmtpSettings']['username'],
                'password' => $params['SmtpSettings']['password'],
                'port' => $params['SmtpSettings']['port'],
                'encryption' => $params['SmtpSettings']['encryption'],
                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]
            ],
        ],
        'timezone' => [
            'class' => 'yii2mod\timezone\Timezone',
            'actionRoute' => '/site/timezone' //optional param - full path to page must be specified
        ],
    ],
    'params' => $params,
];
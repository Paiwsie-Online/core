<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/

$domainParamsCommon = [];
$domainParamsLocal = [];

if (file_exists(__DIR__ . '/../../../common/config/domainParams/'.$_SERVER['HTTP_HOST'].'.php')) {
    $domainParamsCommon = require __DIR__ . '/../../../common/config/domainParams/'.$_SERVER['HTTP_HOST'].'.php';
}
if (file_exists(__DIR__ . '/../../config/domainParams/'.$_SERVER['HTTP_HOST'].'.php')) {
    $domainParamsLocal = require __DIR__ . '/../../config/domainParams/'.$_SERVER['HTTP_HOST'].'.php';
}

$params = array_replace_recursive(
    require __DIR__ . '/../../../common/config/core/params.php',
    require __DIR__ . '/../../config/core/params.php',
    require __DIR__ . '/../../../common/config/params.php',
    require __DIR__ . '/../../config/params.php',
    require __DIR__ . '/../../../common/config/params-local.php',
    require __DIR__ . '/../../config/params-local.php',
    $domainParamsCommon,
    $domainParamsLocal
);

return [
    'id' => 'app-backend',
    'name'  =>  $params['default_site_settings']['site_name'],
    'bootstrap' => [
        'log',
        'timezone',
        'translatemanager' => [
            'class' => 'lajax\translatemanager\Component'
        ],
    ],
    'controllerMap' => [
        'api' => 'backend\controllers\core\ApiController',
        'api-key' => 'backend\controllers\core\ApiKeyController',
        'organization' => 'backend\controllers\core\OrganizationController',
        'organization-group-module-right' => 'backend\controllers\core\OrganizationGroupModuleRightController',
        'organization-setting' => 'backend\controllers\core\OrganizationSettingController',
        'organization-usergroup' => 'backend\controllers\core\OrganizationUsergroupController',
        'organization-usergroup-user-relation' => 'backend\controllers\core\OrganizationUsergroupUserRelationController',
        'organization-user-module-right' => 'backend\controllers\core\OrganizationUserModuleRightController',
        'organization-user-relation' => 'backend\controllers\core\OrganizationUserRelationController',
        'cronjob' => 'backend\controllers\core\CronjobController',
        'enumeration' => 'backend\controllers\core\EnumerationController',
        'qr' => 'backend\controllers\core\QrController',
        'site' => 'backend\controllers\core\SiteController',
        'system-admin' => 'backend\controllers\core\SystemAdminController',
        'system-content' => 'backend\controllers\core\SystemContentController',
        'system-log' => 'backend\controllers\core\SystemLogController',
        'user' => 'backend\controllers\core\UserController',
        'user-login' => 'backend\controllers\core\UserLoginController',
        'user-setting' => 'backend\controllers\core\UserSettingController',
    ],
    'controllerNamespace' => 'backend\controllers\core',
    'modules' => [
        'translatemanager' => [
            'class' => 'lajax\translatemanager\Module',
            'root'  => [__DIR__ . '/../../../backend', __DIR__ . '/../../../common'],             //'@app',
            'scanRootParentDirectory' => false,
            'layout' => '@app/views/layouts/core/translation',
            'tables' => [
                [
                    'connection' => 'db',
                    'table' => 'module',
                    'columns' => ['name', 'description'],
                    'category' => 'database-table-name'
                ],
                [
                    'connection' => 'db',
                    'table' => 'system_content',
                    'columns' => ['value'],
                    'category' => 'database-table-name'
                ],
                [
                    'connection' => 'db',
                    'table' => 'language_force_translation',
                    'columns' => ['value'],
                    'category' => 'database-table-name'
                ],
            ],
            'allowedIPs' => ['127.0.0.1' , '45.85.180.8', '*'],
            'viewPath' => '@app/views/core/translation'
        ],
    ],
    'language' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'translatemanager' => [
            'class' => 'lajax\translatemanager\Component'
        ],
        'request' => [
            'cookieValidationKey' => 'change_now_your_validation_key',
            'csrfParam' => '_csrf-backend',
            'enableCsrfValidation' => false,
        ],
        'baseController' => [
            'class' => 'backend\components\core\BaseController'
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
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'name' => 'advanced-backend',
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
        // Following lines to permit to add custom view in backend/views, if not found takes automatically the core view in backend/views/core folder
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@backend/views' => [
                        '@backend/views',
                        '@backend/views/core'
                    ]
                ]
            ]
        ],
    ],
    'params' => $params,
];
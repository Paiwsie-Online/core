<?php

/** @var $params */

return [
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
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
    'controllerMap' => [
        'site' => 'backend\controllers\SiteController',
        'team' => 'backend\controllers\TeamController',
        'association' => 'backend\controllers\AssociationController',
        'organization-user-relation' => 'backend\controllers\OrganizationUserRelationController',
        'user' => 'backend\controllers\UserController',
    ],
    'layout' => $params['layout']['main']
];
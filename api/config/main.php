<?php

use yii\rest\UrlRule;

return [
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
    ],
    'modules' => [],
];

<?php

return [
    [
        'title' => Yii::t('core_system', 'About'),
        'href' => 'https://www.paiwise.com/about',
    ],
    [
        'title' => Yii::t('core_system', 'Help'),
        'href' => 'https://www.paiwise.com/about'
    ],
    [
        'title' => Yii::t('core_system', 'Contact'),
        'href' => '/site/contact'
    ],
    [
        'title' => Yii::t('core_system', 'Terms &amp; Conditions'),
        'href' => '/site/termsandconditions'
    ],
    [
        'title' => Yii::t('core_system', 'System info'),
        'href' => '/site/systeminfo',
        'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
    ]
];

<?php

return [
    [
        'title' => Yii::t('core_system', 'ORGANIZATION ADMIN'),
        'css' => 'small font-weight-semibold',
        'visible' => (isset(Yii::$app->user->identity->organizationUserLevel)
            && (Yii::$app->user->identity->organizationUserLevel === 'admin' || Yii::$app->user->identity->organizationUserLevel === 'owner')),
        'items' => [
            [
                'title' => Yii::t('core_system', 'Modules'),
                'href' => '/organization/modules',
                'icon' => 'ri-function-line',
                'css' => 'navigation-modules',
                'active' => (Yii::$app->controller->id === 'organization' && Yii::$app->controller->action->id === 'modules')
            ],
            [
                'title' => Yii::t('core_organization', 'User groups'),
                'href' => '/organization-usergroup/list',
                'icon' => 'ri-team-line',
                'active' => (Yii::$app->controller->id === 'organization-usergroup' && (in_array(Yii::$app->controller->action->id, ['list', 'newgroup', 'update', 'view', 'add-user'], true))),
            ],
            [
                'title' => Yii::t('core_organization', 'Users'),
                'href' => '/organization-user-relation/list',
                'icon' => 'mdi mdi-account-circle-outline',
                'active' => ((in_array(Yii::$app->controller->id, ['organization-user-relation', 'organization-usergroup-user-relation'])) && (in_array(Yii::$app->controller->action->id, ['list', 'invite', 'update', 'view', 'add-group'], true))),
            ],
            [
                'title' => Yii::t('core_system', 'Api Keys'),
                'href' => '/api-key/index-organization',
                'icon' => 'ri-key-2-fill',
                'active' => ((Yii::$app->controller->id === 'api-key') && (in_array(Yii::$app->controller->action->id, ['index-organization', 'view-organization', 'create-organization', 'update-organization'], true))),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('digitalAccount', 'read')),
            ],
            [
                'title' => Yii::t('core_system', 'Settings'),
                'href' => '/organization-setting/organization-details',
                'icon' => 'ri-settings-3-line',
                'active' => ((Yii::$app->controller->id === 'organization-setting') && (in_array(Yii::$app->controller->action->id, ['organization-details', 'bank-info', 'content'])) || (Yii::$app->controller->id === 'vat') && (in_array(Yii::$app->controller->action->id, ['list', 'view-organization', 'create-organization', 'update-organization'], true))),
            ]
        ]
    ],
    [
        'title' => Yii::t('core_system', 'SITE ADMIN'),
        'css' => 'small font-weight-semibold',
        'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('siteAdmin', 'read')),
        'items' => [
            [
                'title' => Yii::t('core_system', 'Content'),
                'href' => '/system-content/index',
                'icon' => 'ri-file-2-line',
                'active' => (Yii::$app->controller->id === 'system-content'),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('siteAdmin', 'read')),
            ],
            [
                'title' =>  Yii::t('core_system','Data Management'),
                'href'  =>  'javascript:void(0)',
                'icon'  =>  'ri-folder-line',
                'active'    =>  (((Yii::$app->controller->id === 'user') && (in_array(Yii::$app->controller->action->id, ['index', 'view'], true))) || ((Yii::$app->controller->id === 'organization') && (in_array(Yii::$app->controller->action->id, ['index', 'view'], true)))),
                'visible'    =>  (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('siteAdmin', 'read')),
                'items' => [
                    [
                        'title' => Yii::t('core_organization', 'Users'),
                        'href' => '/user/index',
                        'active' => ((Yii::$app->controller->id === 'user') && (in_array(Yii::$app->controller->action->id, ['index', 'view'], true))),
                    ],
                    [
                        'title' => Yii::t('core_organization', 'Organizations'),
                        'href' => '/organization/index',
                        'active' => ((Yii::$app->controller->id === 'organization') && (in_array(Yii::$app->controller->action->id, ['index', 'view'], true))),
                    ],
                ]
            ],
            [
                'title' => Yii::t('core_system', 'Api'),
                'href' => 'javascript:void(0)',
                'icon' => 'ri-key-2-fill',
                'active' => ((Yii::$app->controller->id === 'api-key') && (in_array(Yii::$app->controller->action->id, ['index-site-admin', 'view-site-admin', 'create-siteadmin', 'update-site-admin'], true))),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('siteAdmin', 'read')),
                'items' => [
                    [
                        'title' => Yii::t('core_system', 'Keys'),
                        'href' => '/api-key/index-site-admin',
                        'active' => ((Yii::$app->controller->id === 'api-key') && (in_array(Yii::$app->controller->action->id, ['index-site-admin', 'view-site-admin', 'create-siteadmin', 'update-site-admin'], true))),
                    ],
                ]
            ]
        ]
    ],
    [
        'title' => Yii::t('core_system', 'SYSTEM ADMIN'),
        'css' => 'small font-weight-semibold',
        'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
        'items' => [
            [
                'title' => Yii::t('core_system', 'System Translations'),
                'href' => '/translatemanager/language/list',
                'icon' => 'las la-language',
                'active' => (Yii::$app->controller->id === 'translatemanager'),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
            ],
            [
                'title' => Yii::t('core_system', 'System Content'),
                'href' => '/system-content/index',
                'icon' => 'ri-file-2-line',
                'active' => (Yii::$app->controller->id === 'system-content'),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
            ],
            [
                'title' => Yii::t('core_system', 'Enumerations'),
                'href' => '/enumeration/index',
                'icon' => 'ri-database-2-line',
                'active' => (Yii::$app->controller->id === 'enumeration'),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
            ],
            [
                'title' => Yii::t('core_system', 'System Maintenance'),
                'href' => '/system-admin/index',
                'icon' => 'mdi mdi-hammer-wrench',
                'active' => (Yii::$app->controller->id === 'system-admin' && Yii::$app->controller->action->id === 'index'),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('systemAdmin', 'update')),
            ],
            [
                'title' =>  Yii::t('core_system','Data Management'),
                'href'  =>  'javascript:void(0)',
                'icon'  =>  'ri-folder-line',
                'active'    =>  (((Yii::$app->controller->id === 'user') && (in_array(Yii::$app->controller->action->id, ['index', 'view'], true))) || ((Yii::$app->controller->id === 'organization') && (in_array(Yii::$app->controller->action->id, ['index', 'view'], true)))),
                'visible'    =>  (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
                'items' => [
                    [
                        'title' => Yii::t('core_organization', 'Users'),
                        'href' => '/user/index',
                        'active' => ((Yii::$app->controller->id === 'user') && (in_array(Yii::$app->controller->action->id, ['index', 'view'], true))),
                    ],
                    [
                        'title' => Yii::t('core_organization', 'Organizations'),
                        'href' => '/organization/index',
                        'active' => ((Yii::$app->controller->id === 'organization') && (in_array(Yii::$app->controller->action->id, ['index', 'view'], true))),
                    ],
                ]
            ]
        ]
    ],
];

<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */

/* @var $content string */

use common\models\core\Language;
use backend\widgets\Alert;
use common\models\core\UserSetting;
use Imagine\Image\ManipulatorInterface;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use backend\assets\AppAsset;

$this->registerJsFile(Yii::$app->request->baseUrl . '/js/custom.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/timeout.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/popper/popper.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/sidenav.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/intro.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

AppAsset::register($this);
$last30Day = date('Y-m-d', strtotime(date('Y-m-d') . "- 30 days"));

$navigation = [
    [
        'title' => Yii::t('core_system', 'ORGANIZATION ADMIN'),
        'css' => 'small font-weight-semibold',
        'visible' => (isset(Yii::$app->user->identity->organizationUserLevel)
            && (Yii::$app->user->identity->organizationUserLevel === 'superadmin' || Yii::$app->user->identity->organizationUserLevel === 'cashier')),
        'items' => [
            [
                'title' => Yii::t('core_system', 'Modules'),
                'href' => '/organization/modules',
                'icon' => 'far fa-balance-scale',
                'css' => 'navigation-modules',
                'active' => (Yii::$app->controller->id === 'organization' && Yii::$app->controller->action->id === 'modules')
            ],
            [
                'title' => Yii::t('core_organization', 'User groups'),
                'href' => '/organization-usergroup/list',
                'icon' => 'fa fa-users-class',
                'active' => (Yii::$app->controller->id === 'organization-usergroup' && (in_array(Yii::$app->controller->action->id, ['list', 'newgroup', 'update', 'view', 'add-user'], true))),
            ],
            [
                'title' => Yii::t('core_organization', 'Users'),
                'href' => '/organization-user-relation/list',
                'icon' => 'fa fa-users',
                'active' => ((in_array(Yii::$app->controller->id, ['organization-user-relation', 'organization-usergroup-user-relation'])) && (in_array(Yii::$app->controller->action->id, ['list', 'invite', 'update', 'view', 'add-group'], true))),
            ],
            [
                'title' => Yii::t('core_system', 'Api Keys'),
                'href' => '/api-key/index-organization',
                'icon' => 'fas fa-key-skeleton',
                'active' => ((Yii::$app->controller->id === 'api-key') && (in_array(Yii::$app->controller->action->id, ['index-organization', 'view-organization', 'create-organization', 'update-organization'], true))),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('digitalAccount', 'read')),
            ],
            [
                'title' => Yii::t('core_system', 'Settings'),
                'href' => '/organization-setting/organization-details',
                'icon' => 'fas fa-cog',
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
                'icon' => 'fas fa-file-alt',
                'active' => (Yii::$app->controller->id === 'system-content'),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('siteAdmin', 'read')),
            ],
            [
                'title' =>  Yii::t('core_system','Data Management'),
                'href'  =>  'javascript:void(0)',
                'icon'  =>  'fas fa-folders',
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
                'icon' => 'fas fa-key-skeleton',
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
                'icon' => 'far fa-language',
                'active' => (Yii::$app->controller->id === 'translatemanager'),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
            ],
            [
                'title' => Yii::t('core_system', 'System Content'),
                'href' => '/system-content/index',
                'icon' => 'fas fa-file-alt',
                'active' => (Yii::$app->controller->id === 'system-content'),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
            ],
            [
                'title' => Yii::t('core_system', 'Enumerations'),
                'href' => '/enumeration/index',
                'icon' => 'fas fa-file-alt',
                'active' => (Yii::$app->controller->id === 'enumeration'),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
            ],
            [
                'title' => Yii::t('core_system', 'System Maintenance'),
                'href' => '/system-admin/index',
                'icon' => 'fad fa-tools',
                'active' => (Yii::$app->controller->id === 'system-admin' && Yii::$app->controller->action->id === 'index'),
                'visible' => (isset(Yii::$app->user->identity) && Yii::$app->user->identity->hasAccess('systemAdmin', 'update')),
            ],
            [
                'title' =>  Yii::t('core_system','Data Management'),
                'href'  =>  'javascript:void(0)',
                'icon'  =>  'fas fa-folders',
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

// NEW VERSION TO INCLUDE MENU OF THE MODULES IF EXISTS
/*foreach (Yii::$app->modules as $key=>$module) {
    if (file_exists(dirname(__DIR__, 3) . '/modules/' . strtolower($key))) {
        require dirname(__DIR__, 3) . '/modules/' . strtolower($key) . '/backend/views/Layout/layout.php';
        $navigation = addModuleMenu($navigation);
    }
}*/

$userMenu = [
    [
        'icon' => 'fa fa-user',
        'title' => Yii::t('core_system', 'My profile'),
        'href' => '/user/profile'
    ],
    [
        'title' => Yii::t('core_system', 'New organization'),
        'href' => '/organization/register-organization',
        'icon' => 'fas fa-building',
    ],
];

$footerMenu = [
    [
        'title' => Yii::t('core_system', 'About'),
        'href' => 'https://www.paiwise.com/about'                        //'/site/about'
    ],
    [
        'title' => Yii::t('core_system', 'Help'),
        'href' => 'https://www.paiwise.com/about'                        //'/site/help'
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

$languageMenu = Language::getLanguages();
$currentLanguage = Language::findOne(Yii::$app->language);
$user = Yii::$app->user;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="light-style" lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?php $this->registerCsrfMetaTags() ?>
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name='logoutTimer' content='<?=(Yii::$app->session->get('__expire') - time())?>'>

    <?php
    $this->registerJsFile(Yii::$app->request->baseUrl . '/js/guides.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    \lajax\translatemanager\helpers\Language::registerAssets()
    ?>
    <title><?= Html::encode(Yii::$app->name) ?> | <?= Html::encode($this->title) ?></title>

    <!-- Main font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900"
          rel="stylesheet">
    <link rel="stylesheet" href="/fonts/fontawesomepro/fontawesome.css">
    <link rel="stylesheet" href="/fonts/ionicons.css">
    <link rel="stylesheet" href="/css/appwork.css">
    <link rel="stylesheet" href="/css/colors.css">
    <link rel="stylesheet" href="/css/uikit.css">
    <link rel="stylesheet" href="/css/intro.css">
    <link rel="stylesheet" href="/css/intro-modern-theme.css">
    <!-- Layout helpers-->
    <script src="/js/layout-helpers.js"></script>

    <!-- `perfect-scrollbar` library required by SideNav plugin -->
    <link rel="stylesheet" href="/libs/perfect-scrollbar/perfect-scrollbar.css">

    <?php $this->head();
    $theme = UserSetting::findOne(['user_id' => Yii::$app->user->identity->id, 'setting' => 'theme']);
    if (isset($theme)) {
        echo '<link rel="stylesheet" href="/css/themes/' . $theme->value . '.css">';
    } else {
        echo '<link rel="stylesheet" href="/css/themes/' . Yii::$app->params['branding']['themeCss'] . '.css">';
    }
    ?>
</head>
<body>
<div class="page-loader">
    <div class="bg-primary"></div>
</div>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-2">
    <div class="layout-inner">
        <?php

        if (!Yii::$app->user->isGuest) {
            ?>
            <!-- Layout sidenav -->
            <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-dark">
                <div class="app-brand demon-dog">
                <span class="app-brand-logo demon-dog">
                    <img src="<?= Yii::$app->thumbnailer->get(Yii::$app->params['branding']['lightLogo'], 100, 100, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) ?>"
                         alt="" class="img-fluid">
                </span>
                    <a href="/site/index"
                       class="app-brand-text demon-dog sidenav-text font-weight-normal ml-2"><?= Yii::$app->name ?></a>
                    <a href="javascript:void(0)" class="layout-sidenav-toggle sidenav-link text-large ml-auto"><i
                            class="ion ion-md-menu align-middle"></i></a>
                </div>
                <div class="sidenav-divider mt-0"></div>
                <div class="w-100 pl-4 pr-4" id="organizationSelectDiv">
                    <?php
                    $organizationCount = count(Yii::$app->user->identity->organizationList);
                    if ($organizationCount !== 0) {
                        ?>
                        <label for="organizationselect"><?= Yii::t('core_organization', 'Select organization') ?>:</label>
                        <?= Html::dropDownList('organizationselect', (Yii::$app->user->identity->selectedOrganization['id'] ?? null), Yii::$app->user->identity->organizationList, [
                            'class' => 'form-control',
                            'id' => 'organizationselect',
                            'prompt' => Yii::t('core_organization', 'No Organization'),
                            'onchange' => '$.post("' . Yii::$app->urlManager->createUrl("organization/change-active") . '", {id: $(this).val()} ,
                                                                                    function(result) {
                                                                                        console.log(result);
                                                                                    });'
                        ]) ?>

                        <?php
                    }
                    if (!isset(Yii::$app->user->identity->selectedOrganization)) {
                        ?>
                        <br><a href="/organization/register-organization" class='sidenav-link sidenav-addOrganization'><i class="fa fa-plus"></i> <?= Yii::t('core_organization', 'Add Organization') ?></a>
                        <?php
                    }
                    ?>
                </div>
                <!-- Links -->
                <ul class="sidenav-inner py-1">
                    <?php
                    /*Print out navigation menu*/
                    foreach ($navigation as $nav) {
                        if ((isset($nav['visible']) && $nav['visible'] === true) || (!isset($nav['visible']))) {
                            if (isset($nav['title'])) {
                                echo "<li class='sidenav-header " . ($nav['css'] ?? '') . "'>" . ($nav['title'] ?? 'title') . "</li>";
                            }
                            if (isset($nav['items'])) {
                                foreach ($nav['items'] as $item) {
                                    if ((isset($item['visible']) && $item['visible'] === true) || (!isset($item['visible']))) {
                                        echo "<li class='sidenav-item " . ($item['css'] ?? '') . " " . ((isset($item['active']) && $item['active']) ? ' open active' : '') . "'>
                                    <a href='" . ($item['href'] ?? '#') . "' class='sidenav-link " . (isset($item['items']) ? 'sidenav-toggle' : '') . "'>";
                                        if (isset($item['icon'])) {
                                            echo "<i class='sidenav-icon {$item['icon']}'></i>";
                                        }
                                        echo "<div>" . ($item['title'] ?? 'title') . "</div></a>";
                                        if (isset($item['items'])) {
                                            echo "<ul class='sidenav-menu'>";
                                            foreach ($item['items'] as $navLink) {
                                                if ((isset($navLink['visible']) && $navLink['visible'] === true) || (!isset($navLink['visible']))) {
                                                    echo "<li class='sidenav-item " . ($navLink['css'] ?? '') . " " . ((isset($navLink['active']) && $navLink['active']) ? ' active' : '') . "'>
                                                    <a href='" . ($navLink['href'] ?? '#') . "' class='sidenav-link'>";
                                                    if (isset($navLink['icon'])) {
                                                        echo "<i class='sidenav-icon {$navLink['icon']}'></i>";
                                                    }
                                                    echo "<div>" . ($navLink['title'] ?? 'title') . "</div>
                                                    </a>
                                                </li>";
                                                }
                                            }
                                            echo "</ul>";
                                        }
                                        echo "</li>";
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    <?php
                    if (isset(Yii::$app->user->identity->selectedOrganization->kycdone)) {
                        $kycdone = Yii::$app->user->identity->selectedOrganization->kycdone;
                        if ($kycdone) {
                            ?>
                            <li class="sidenav-item">
                                <label class="switcher switcher-warning switcher-lg ml-4 mt-5">
                                    <input type="checkbox" id="testModeSwitch"
                                           class="switcher-input"<?= (isset($_SESSION['testMode']) && $_SESSION['testMode'] === true ? ' checked' : '') ?>>
                                    <span class="switcher-label text-warning"><?= Yii::t('core_system', 'Test mode') ?></span>
                                    <span class="switcher-indicator">
                            <span class="switcher-yes">
                                <span class="ion ion-md-checkmark"></span>
                            </span>
                            <span class="switcher-no">
                                <span class="ion ion-md-close text-default"></span>
                            </span>
                        </span>
                                </label>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <!-- / Layout sidenav -->
            <?php
        }
        ?>
        <!-- Layout container -->
        <div class="layout-container">
            <!-- Layout navbar -->
            <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-white container-p-x"
                 id="layout-navbar">
                <?php
                if (!Yii::$app->user->isGuest) {
                    ?>
                    <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center">
                        <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:void(0)">
                            <i class="ion ion-md-menu text-large align-middle"></i>
                        </a>
                    </div>
                    <?php
                }
                ?>
                <a href="/site/index" class="navbar-brand app-brand d-lg-none demon-dog py-0 mr-4">
                    <img src="/img/logo.png" alt="site logo" class="img-fluid"
                         style="max-height: 25px;"> <?= Yii::$app->name ?>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#layout-navbar-collapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse" id="layout-navbar-collapse">
                    <!-- Divider -->
                    <hr class="d-lg-none w-100 my-2">
                    <div class="navbar-nav align-items-lg-center ml-auto">
                        <div class="demon-dog-navbar-user nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                               aria-expanded="false">
                              <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                <span class="px-1 mr-lg-2 ml-2 ml-lg-0 textColor"><?= $currentLanguage->name . ($currentLanguage->status === 2 ? ' <span class="text-warning">' . Yii::t('core_system', 'Beta') . '</span>' : '') ?></span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right"
                                 style="max-height: 300px; overflow-y: auto">
                                <?php
                                foreach ($languageMenu as $language) {
                                    if ($language->language_id !== Yii::$app->language) {
                                        echo Html::a($language->name . ($language->status === 2 ? ' <span class="text-warning">' . Yii::t('core_system', 'Beta') . '</span>' : ''), ['/user-setting/set', 'setting' => 'language', 'value' => $language->language_id], [
                                            'class' => 'dropdown-item',
                                            'data' => [
                                                'method' => 'post',
                                            ],
                                        ]);
                                    }

                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if (Yii::$app->user->isGuest) {
                            echo "<div class='nav-item text-big font-weight-light mr-3 ml-1'><a href='/site/login' title='log in' data-filter-tags='log in'>
                                    <i class='fas fa-sign-in-alt navbar-icon align-middle'></i> &nbsp;
                                    <span class='nav-link-text'>" . Yii::t('core_system', 'Sign in') . "</span>
                                </a></div>";
                        }
                        if (!Yii::$app->user->isGuest) {
                            ?>
                            <div class="demon-dog-navbar-user user-menu nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                   aria-expanded="false">
                              <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle textColor">
                                   <img src="<?= (isset(Yii::$app->user->identity->picture['uri']) ? Yii::$app->thumbnailer->get(Yii::$app->user->identity->picture['uri'], 30, 30, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) : '/img/avatars/1.png') ?>"
                                        alt class="d-block ui-w-30 rounded-circle">
                                <span class="px-1 mr-lg-2 ml-2 ml-lg-0"><?= Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name ?></span>
                              </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php
                                    foreach ($userMenu as $uM) {
                                        if ((isset($uM['visible']) && $uM['visible'] === true) || (!isset($uM['visible']))) {
                                            echo "<a href='" . ($uM['href'] ?? '#') . "' class='dropdown-item'>";
                                            if (isset($uM['icon'])) {
                                                echo "<i class='{$uM['icon']} text-muted'></i>";
                                            }
                                            echo " &nbsp; " . ($uM['title'] ?? 'Title') . "</a>";
                                        }
                                    }
                                    $userSetting = UserSetting::findOne(['user_id' => Yii::$app->user->identity->id, 'setting' => 'theme']);
                                    echo Html::a('<label class="switcher switcher-warning ml-4">
                                    <input type="checkbox" id="themeSwitch" class="switcher-input" ' . (isset($userSetting) ? ($userSetting->value === 'light' ? '' : 'checked') : (Yii::$app->params['branding']['themeCss'] === 'light' ? '' : 'checked')) . '>
                                    <span class="switcher-label">' . (isset($userSetting) ? ($userSetting->value === 'light' ? Yii::t('core_system', 'Light theme') : Yii::t('core_system', 'Dark theme')) : (Yii::$app->params['branding']['themeCss'] === 'light' ? Yii::t('core_system', 'Light theme') : Yii::t('core_system', 'Dark theme'))) . '</span>
                                    <span class="switcher-indicator">
                                        <span class="switcher-yes activated">
                                            <span class="fas fa-moon text-info"></span>
                                        </span>
                                        <span class="switcher-no no-activated">
                                            <span class="fad fa-sun text-default"></span>
                                        </span>
                                    </span>
                                </label>', ['/user-setting/set', 'setting' => 'theme', 'value' => (isset($userSetting) ? ($userSetting->value === 'light' ? 'dark' : 'light') : (Yii::$app->params['branding']['themeCss'] === 'light' ? 'dark' : 'light'))], [
                                        'data' => [
                                            'method' => 'post',
                                        ],
                                    ]);
                                    ?>
                                    <div class="dropdown-divider"></div>
                                    <?= Html::beginForm(['/site/logout'], 'post')
                                    . Html::submitButton(
                                        '<i class="ion ion-ios-log-out text-danger"></i> &nbsp; ' . Yii::t('core_system', 'Logout'),
                                        ['class' => 'btn btn-link logout dropdown-item']
                                    )
                                    . Html::endForm() ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </nav>
            <!-- / Layout navbar -->
            <!-- Layout content -->
            <div class="layout-content">
                <!-- Content -->
                <div class="container-fluid flex-grow-1 container-p-y">
                    <?php
                    if (isset($_SESSION['testMode']) && $_SESSION['testMode'] === true) {
                        echo "<div class='w-100 bg-warning p-3 mb-2 testModeMessage'><i class='fas fa-exclamation-triangle mr-2 ml-2 fs-5'></i> " . Yii::t('core_system', 'You are currently in Test Mode, for more information') . " <strong><a href='/site/test-mode'>" . Yii::t('core_system', 'click here') . "</a></strong></div>";
                    }
                    ?>
                    <?= Alert::widget() ?>
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= $content ?>
                </div>
                <!-- / Content -->
                <!-- Layout footer -->
                <nav class="layout-footer footer">
                    <div class="container-fluid d-flex flex-wrap justify-content-between text-center container-p-x pb-3">
                        <div class="pt-3">
                            <span class="footer-text font-weight-bolder">Trust Anchor Group</span>
                            © <?= date('Y') ?>
                        </div>
                        <div>
                            <?php
                            foreach ($footerMenu as $fM) {
                                if ((isset($fM['visible']) && $fM['visible'] === true) || (!isset($fM['visible']))) {
                                    echo "<a href='" . ($fM['href'] ?? '#') . "' class='footer-link pt-3 ml-4'>";
                                    if (isset($fM['icon'])) {
                                        echo "<i class='{$fM['icon']} text-muted'></i>";
                                    }
                                    echo " " . ($fM['title'] ?? 'Title') . "</a>";

                                }
                            }
                            ?>
                        </div>
                    </div>
                </nav>
                <!-- / Layout footer -->
            </div>
            <!-- Layout content -->
        </div>
        <!-- / Layout container -->
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-sidenav-toggle"></div>
</div>

<?php
Modal::begin([
    'title' => 'Site modal',
    'id' => 'site-modal',
    'size' => 'modal-lg'
]);
echo "<div id='site-modal-body'></div>";
Modal::end();

// Inactive session modal
Modal::begin([
    'title' => 'Expire Session Warning',
    'id' => 'site-modal-warning',
    'size' => 'modal-lg'
]);
?>
<div id="site-modal-warning-body">
    <div class="col-12 mt-3" id="logoutModal">
        <h6 class="mb-3 mt-4">
            Your session expires in <span class="countdown"><?=(Yii::$app->session->get('__expire') - time())?></span> seconds.
        </h6>
        <span class="float-right mb-3">
                <?=Html::a(Yii::t('core_system', 'Continue Session'), ['/user-login/continue-session'], ['class' => 'btn btn-warning mr-3'])?>
                <?=Html::a(Yii::t('core_system', 'Logout'), ['/site/logout'], [
                    'class' => 'btn btn-outline-danger',
                    'id' => 'logoutButton'
                ])?>
            </span>
    </div>
</div>
<?php
Modal::end();

$this->endBody()
?>
<input id="timeOutValue" type="hidden" value="<?=Yii::$app->params['systemTimeout']['authTimeout']?>">
<input id="modalShowValue" type="hidden" value="<?=Yii::$app->params['systemTimeout']['modalShow']?>">
</body>
</html>
<?php $this->endPage() ?>
<script>
    $(document).ready(function() {
        $('#site-modal-warning').find('button.close').hide();
        $('#site-modal-warning').on('keydown', disableF5Pressed);
        setInterval(function() {
            if (logoutTimer >= 0) {
                $('span.countdown').html(logoutTimer);
            }
        }, intervalTime);
    });

</script>

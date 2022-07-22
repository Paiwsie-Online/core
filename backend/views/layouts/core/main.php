<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */

/* @var $content string */

use backend\widgets\Alert;
use common\models\core\Language;
use Imagine\Image\ManipulatorInterface;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/custom.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/timeout.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/layout.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/bootstrap/js/bootstrap.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/simplebar/simplebar.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/node-waves/waves.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/feather-icons/feather.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile(Yii::$app->request->baseUrl . '/js/pages/plugins/lord-icon-2.1.0.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/plugins.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/apexcharts/apexcharts.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/jsvectormap/js/jsvectormap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/jsvectormap/maps/world-merc.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/swiper/swiper-bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile(Yii::$app->request->baseUrl . '/js/pages/dashboard-ecommerce.init.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/app.js', ['depends' => [\yii\bootstrap5\BootstrapPluginAsset::class]]);

//$this->registerCssFile(Yii::$app->request->baseUrl . '/libs/jsvectormap/css/jsvectormap.min.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/libs/swiper/swiper-bundle.min.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/icons.min.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/app.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/custom.min.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/project.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);

$last30Day = date('Y-m-d', strtotime(date('Y-m-d') . "- 30 days"));

$navigation = require Yii::$app->basePath . '/config/navigations'.Yii::$app->params['navigations']['main'].'.php';
$userMenu = require Yii::$app->basePath . '/config/navigations'.Yii::$app->params['navigations']['user'].'.php';
$footerMenu = require Yii::$app->basePath . '/config/navigations'.Yii::$app->params['navigations']['footer'].'.php';


$languageMenu = Language::getLanguages();
$currentLanguage = Language::findOne(Yii::$app->language);
$user = Yii::$app->user;
?>


<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <?php $this->registerCsrfMetaTags() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name='logoutTimer' content='<?=(Yii::$app->session->get('__expire') - time())?>'>
    <!-- App favicon -->
    <link rel="shortcut icon" href="/img/favicon.ico">
    <title><?= Html::encode(Yii::$app->name) ?> | <?= Html::encode($this->title) ?></title>
    <?php
    $this->registerJsFile(Yii::$app->request->baseUrl . '/js/guides.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    //\lajax\translatemanager\helpers\Language::registerAssets()
    ?>
    <?php $this->head(); ?>
</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="/site/index" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="/img/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="/img/logo-dark.png" alt="" height="17">
                        </span>
                        </a>

                        <a href="/site/index" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="/img/logo-sm.png" alt="" height="22">
                        </span>
                            <span class="logo-lg">
                            <img src="/img/logo-light.png" alt="aaa" height="17">
                        </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    </button>

                    <!-- App Search-->
                    <?php
                    // Search
                    /*
                    <form class="app-search d-none d-md-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" value="">
                            <span class="mdi mdi-magnify search-widget-icon"></span>
                            <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                        </div>

                        <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                            <div data-simplebar style="max-height: 320px;">
                                <!-- item-->
                                <div class="dropdown-header">
                                    <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                                </div>

                                <div class="dropdown-item bg-transparent text-wrap">
                                    <a href="/site/index" class="btn btn-soft-secondary btn-sm btn-rounded">how to setup <i class="mdi mdi-magnify ms-1"></i></a>
                                    <a href="/site/index" class="btn btn-soft-secondary btn-sm btn-rounded">buttons <i class="mdi mdi-magnify ms-1"></i></a>
                                </div>
                                <!-- item-->
                                <div class="dropdown-header mt-2">
                                    <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                                </div>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                    <span>Analytics Dashboard</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                    <span>Help Center</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                    <span>My account settings</span>
                                </a>

                                <!-- item-->
                                <div class="dropdown-header mt-2">
                                    <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                                </div>

                                <div class="notification-list">
                                    <!-- item -->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                        <div class="d-flex">
                                            <img src="/img/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="m-0">Angela Bernier</h6>
                                                <span class="fs-11 mb-0 text-muted">Manager</span>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- item -->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                        <div class="d-flex">
                                            <img src="/img/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="m-0">David Grasso</h6>
                                                <span class="fs-11 mb-0 text-muted">Web Designer</span>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- item -->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                        <div class="d-flex">
                                            <img src="/img/users/avatar-5.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="m-0">Mike Bunch</h6>
                                                <span class="fs-11 mb-0 text-muted">React Developer</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="text-center pt-3 pb-1">
                                <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results <i class="ri-arrow-right-line ms-1"></i></a>
                            </div>
                        </div>
                    </form>
                    */
                    ?>
                </div>

                <div class="d-flex align-items-center">

                    <?php
                    // ???
                    /*
                    <div class="dropdown d-md-none topbar-head-dropdown header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-search fs-22"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    */
                    ?>

                    <?php
                    // Flags
                    ?>

                    <div class="dropdown ms-1 topbar-head-dropdown header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary shadow-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="/img/flags/<?= $currentLanguage->country ?>.png" alt="user-image" class="me-2 rounded" height="25">
                        </button>

                        <div class="dropdown-menu dropdown-menu-end">
                            <?php
                            foreach ($languageMenu as $language) {
                                if ($language->language_id !== Yii::$app->language) {
                                    echo Html::a($language->name . ($language->status === 2 ? ' <span class="text-warning">' . Yii::t('core_system', 'Beta') . '</span>' : ''), ['/user-setting/set', 'setting' => 'language', 'value' => $language->language_id], [
                                        'class' => 'dropdown-item notify-item language',
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
                    // Web apps
                    /*
                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='bx bx-category-alt fs-22'></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end">
                            <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fw-semibold fs-15"> Web Apps </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="btn btn-sm btn-soft-info"> View All Apps
                                            <i class="ri-arrow-right-s-line align-middle"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="/img/brands/github.png" alt="Github">
                                            <span>GitHub</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="/img/brands/bitbucket.png" alt="bitbucket">
                                            <span>Bitbucket</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="/img/brands/dribbble.png" alt="dribbble">
                                            <span>Dribbble</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="/img/brands/dropbox.png" alt="dropbox">
                                            <span>Dropbox</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="/img/brands/mail_chimp.png" alt="mail_chimp">
                                            <span>Mail Chimp</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="/img/brands/slack.png" alt="slack">
                                            <span>Slack</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    */
                    ?>

                    <?php
                    // Webshop
                    /*
                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-cart-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                            <i class='bx bx-shopping-bag fs-22'></i>
                            <span class="position-absolute topbar-badge cartitem-badge fs-10 translate-middle badge rounded-pill bg-info">5</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart" aria-labelledby="page-header-cart-dropdown">
                            <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold"> My Cart</h6>
                                    </div>
                                    <div class="col-auto">
                                    <span class="badge badge-soft-warning fs-13"><span class="cartitem-badge">7</span>
                                        items</span>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 300px;">
                                <div class="p-2">
                                    <div class="text-center empty-cart" id="empty-cart">
                                        <div class="avatar-md mx-auto my-3">
                                            <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle">
                                                <i class='bx bx-cart'></i>
                                            </div>
                                        </div>
                                        <h5 class="mb-3">Your Cart is Empty!</h5>
                                        <a href="apps-ecommerce-products.html" class="btn btn-success w-md mb-3">Shop Now</a>
                                    </div>
                                    <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                        <div class="d-flex align-items-center">
                                            <img src="/img/products/img-1.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="mt-0 mb-1 fs-14">
                                                    <a href="apps-ecommerce-product-details.html" class="text-reset">Branded
                                                        T-Shirts</a>
                                                </h6>
                                                <p class="mb-0 fs-12 text-muted">
                                                    Quantity: <span>10 x $32</span>
                                                </p>
                                            </div>
                                            <div class="px-2">
                                                <h5 class="m-0 fw-normal">$<span class="cart-item-price">320</span></h5>
                                            </div>
                                            <div class="ps-2">
                                                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i class="ri-close-fill fs-16"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                        <div class="d-flex align-items-center">
                                            <img src="/img/products/img-2.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="mt-0 mb-1 fs-14">
                                                    <a href="apps-ecommerce-product-details.html" class="text-reset">Bentwood Chair</a>
                                                </h6>
                                                <p class="mb-0 fs-12 text-muted">
                                                    Quantity: <span>5 x $18</span>
                                                </p>
                                            </div>
                                            <div class="px-2">
                                                <h5 class="m-0 fw-normal">$<span class="cart-item-price">89</span></h5>
                                            </div>
                                            <div class="ps-2">
                                                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i class="ri-close-fill fs-16"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                        <div class="d-flex align-items-center">
                                            <img src="/img/products/img-3.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="mt-0 mb-1 fs-14">
                                                    <a href="apps-ecommerce-product-details.html" class="text-reset">
                                                        Borosil Paper Cup</a>
                                                </h6>
                                                <p class="mb-0 fs-12 text-muted">
                                                    Quantity: <span>3 x $250</span>
                                                </p>
                                            </div>
                                            <div class="px-2">
                                                <h5 class="m-0 fw-normal">$<span class="cart-item-price">750</span></h5>
                                            </div>
                                            <div class="ps-2">
                                                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i class="ri-close-fill fs-16"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                        <div class="d-flex align-items-center">
                                            <img src="/img/products/img-6.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="mt-0 mb-1 fs-14">
                                                    <a href="apps-ecommerce-product-details.html" class="text-reset">Gray
                                                        Styled T-Shirt</a>
                                                </h6>
                                                <p class="mb-0 fs-12 text-muted">
                                                    Quantity: <span>1 x $1250</span>
                                                </p>
                                            </div>
                                            <div class="px-2">
                                                <h5 class="m-0 fw-normal">$ <span class="cart-item-price">1250</span></h5>
                                            </div>
                                            <div class="ps-2">
                                                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i class="ri-close-fill fs-16"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                        <div class="d-flex align-items-center">
                                            <img src="/img/products/img-5.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="mt-0 mb-1 fs-14">
                                                    <a href="apps-ecommerce-product-details.html" class="text-reset">Stillbird Helmet</a>
                                                </h6>
                                                <p class="mb-0 fs-12 text-muted">
                                                    Quantity: <span>2 x $495</span>
                                                </p>
                                            </div>
                                            <div class="px-2">
                                                <h5 class="m-0 fw-normal">$<span class="cart-item-price">990</span></h5>
                                            </div>
                                            <div class="ps-2">
                                                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i class="ri-close-fill fs-16"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border" id="checkout-elem">
                                <div class="d-flex justify-content-between align-items-center pb-3">
                                    <h5 class="m-0 text-muted">Total:</h5>
                                    <div class="px-2">
                                        <h5 class="m-0" id="cart-item-total">$1258.58</h5>
                                    </div>
                                </div>

                                <a href="apps-ecommerce-checkout.html" class="btn btn-success text-center w-100">
                                    Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                    */
                    ?>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-toggle="fullscreen">
                            <i class='bx bx-fullscreen fs-22'></i>
                        </button>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                            <i class='bx bx-moon fs-22'></i>
                        </button>
                    </div>

                    <?php
                    // Notifications/Messages
                    /*
                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='bx bx-bell fs-22'></i>
                            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span class="visually-hidden">unread messages</span></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                            <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                        </div>
                                        <div class="col-auto dropdown-tabs">
                                            <span class="badge badge-soft-light fs-13"> 4 New</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 pt-2">
                                    <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true">
                                                All (4)
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab" aria-selected="false">
                                                Messages
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-bs-toggle="tab" href="#alerts-tab" role="tab" aria-selected="false">
                                                Alerts
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="tab-content" id="notificationItemsTabContent">
                                <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                                </div>
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 lh-base">Your <b>Elite</b> author Graphic
                                                            Optimization <span class="text-secondary">reward</span> is
                                                            ready!
                                                        </h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> Just 30 sec ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="all-notification-check01">
                                                        <label class="form-check-label" for="all-notification-check01"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item position-relative active">
                                            <div class="d-flex">
                                                <img src="/img/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Angela Bernier</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">Answered to your comment on the cash flow forecast's
                                                            graph 🔔.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 48 min ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="all-notification-check02" checked>
                                                        <label class="form-check-label" for="all-notification-check02"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-soft-danger text-danger rounded-circle fs-16">
                                                    <i class='bx bx-message-square-dots'></i>
                                                </span>
                                                </div>
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 fs-13 lh-base">You have received <b class="text-success">20</b> new messages in the conversation
                                                        </h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 2 hrs ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="all-notification-check03">
                                                        <label class="form-check-label" for="all-notification-check03"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <img src="/img/users/avatar-8.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Maureen Gibson</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">We talked about a project on linkedin.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 4 hrs ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="all-notification-check04">
                                                        <label class="form-check-label" for="all-notification-check04"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="my-3 text-center">
                                            <button type="button" class="btn btn-soft-success waves-effect waves-light">View
                                                All Notifications <i class="ri-arrow-right-line align-middle"></i></button>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel" aria-labelledby="messages-tab">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="/img/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">James Lemire</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">We talked about a project on linkedin.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 30 min ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="messages-notification-check01">
                                                        <label class="form-check-label" for="messages-notification-check01"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="/img/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Angela Bernier</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">Answered to your comment on the cash flow forecast's
                                                            graph 🔔.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 2 hrs ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="messages-notification-check02">
                                                        <label class="form-check-label" for="messages-notification-check02"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="/img/users/avatar-6.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Kenneth Brown</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">Mentionned you in his comment on 📃 invoice #12501.
                                                        </p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 10 hrs ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="messages-notification-check03">
                                                        <label class="form-check-label" for="messages-notification-check03"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="/img/users/avatar-8.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Maureen Gibson</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">We talked about a project on linkedin.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 3 days ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="messages-notification-check04">
                                                        <label class="form-check-label" for="messages-notification-check04"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="my-3 text-center">
                                            <button type="button" class="btn btn-soft-success waves-effect waves-light">View
                                                All Messages <i class="ri-arrow-right-line align-middle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-4" id="alerts-tab" role="tabpanel" aria-labelledby="alerts-tab">
                                    <div class="w-25 w-sm-50 pt-3 mx-auto">
                                        <img src="/img/svg/bell.svg" class="img-fluid" alt="user-pic">
                                    </div>
                                    <div class="text-center pb-5 mt-2">
                                        <h6 class="fs-18 fw-semibold lh-base">Hey! You have no any notifications </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    */
                    ?>

                    <?php
                    // User Profile
                    if (Yii::$app->user->isGuest) {
                        echo "<div class='nav-item text-big font-weight-light mr-3 ml-1'><a href='/site/login' title='log in' data-filter-tags='log in'>
                                    <i class='fas fa-sign-in-alt navbar-icon align-middle'></i> &nbsp;
                                    <span class='nav-link-text'>" . Yii::t('core_system', 'Sign in') . "</span>
                                </a></div>";
                    }
                    if (!Yii::$app->user->isGuest) {
                    ?>
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <a href="/site/index" type="button" class="btn shadow-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img src="<?= (isset(Yii::$app->user->identity->picture['uri']) ? Yii::$app->thumbnailer->get(Yii::$app->user->identity->picture['uri'], 30, 30, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) : Yii::$app->thumbnailer->get('/img/avatars/1.png', 30, 30, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true)) ?>" alt class="d-block w-25 rounded-circle">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name ?></span>
                                        <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?= (Yii::$app->user->identity->organizationUserLevel ? ucfirst(Yii::$app->user->identity->organizationUserLevel) : '') ?></span>
                                    </span>

                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header"><?= Yii::t('core_system', 'Welcome') . ' ' . Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name ?></h6>
                                <div class="dropdown-divider"></div>
                                <?php
                                foreach ($userMenu as $uM) {
                                    if ((isset($uM['visible']) && $uM['visible'] === true) || (!isset($uM['visible']))) {
                                        echo "<a href='" . ($uM['href'] ?? '#') . "' class='dropdown-item'>";
                                        if (isset($uM['icon'])) {
                                            echo "<i class='{$uM['icon']} text-muted'></i>";
                                        }
                                        echo "<span class='align-middle'>" . ($uM['title'] ?? 'Title') . "</span></a>";
                                    }
                                }
                                ?>
                                <div class="dropdown-divider"></div>
                                <?= Html::beginForm(['/site/logout'], 'post')
                                . Html::submitButton(
                                    '<i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">' . Yii::t('core_system', 'Logout') . '</span>',
                                    ['class' => 'dropdown-item']
                                )
                                . Html::endForm() ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>
    <!-- ========== App Menu ========== -->

    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="/site/index" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="/img/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="/img/logo-dark.png" alt="" height="17">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="/site/index" class="logo logo-light">
                <span class="logo-sm">
                    <img src="/img/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="/img/logo-light.png" alt="" height="17">
                </span>
            </a>
            <a href="" type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </a>
            <?php
            if (!Yii::$app->user->isGuest) {
            ?>
                <div class="w-100 pl-4 pr-4" id="organizationSelectDiv">
                    <?php
                    $organizationCount = count(Yii::$app->user->identity->organizationList);
                    if ($organizationCount !== 0) {
                        ?>
                        <label for="organizationselect" class="text-light"><?= Yii::t('core_organization', 'Select organization') ?>:</label>
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
            <?php
            }
            ?>
        </div>

        <div id="scrollbar">
            <div class="container-fluid">

                <div id="two-column-menu">
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <?php
                    /*Print out navigation menu*/
                    foreach ($navigation as $nav) {
                        if ((isset($nav['visible']) && $nav['visible'] === true) || (!isset($nav['visible']))) {
                            if (isset($nav['title'])) {
                                echo "<li class='menu-title'><span data-key='t-menu'>" . ($nav['title'] ?? 'title') . "</span></li>";
                            }
                            if (isset($nav['items'])) {
                                foreach ($nav['items'] as $item) {
                                    if ((isset($item['visible']) && $item['visible'] === true) || (!isset($item['visible']))) {
                                        echo "<li class='nav-item'>
                                            <a " . (!isset($item['items']) ? "href='" . ($item['href'] ?? '#') . "'" : "href='#" . str_replace(' ', '', $item['title']) . "'") . " class='nav-link menu-link " . ((isset($item['active']) && $item['active']) ? ' open active' : '') . "' " . (isset($item['items']) ? "data-bs-toggle='collapse' role='button' aria-expanded='false' aria-controls='" . str_replace(' ', '', $item['title']) . "'" : "") . ">";
                                            if (isset($item['icon'])) {
                                                echo "<i class='{$item['icon']}'></i>";
                                            }
                                            echo "<span data-key='t-'" . ($item['title'] ?? 'title') . "'>" . ($item['title'] ?? 'title') . "</span></a>";
                                            if (isset($item['items'])) {
                                            ?>
                                                <div class="collapse menu-dropdown <?= ((isset($item['active']) && $item['active']) ? ' show' : '') ?>" id="<?= str_replace(' ', '', $item['title']) ?>">
                                                    <ul class="nav nav-sm flex-column">
                                                        <?php
                                                        foreach ($item['items'] as $navLink) {
                                                            if ((isset($navLink['visible']) && $navLink['visible'] === true) || (!isset($navLink['visible']))) {
                                                                echo "<li class='nav-item'>
                                                                    <a href='" . ($navLink['href'] ?? '#') . "' class='nav-link " . ((isset($navLink['active']) && $navLink['active']) ? ' active' : '') . "'>";
                                                                        if (isset($navLink['icon'])) {
                                                                            echo "<i class='{$navLink['icon']}'></i>";
                                                                        }
                                                                        echo "<span data-key='t-'" . ($item['title'] ?? 'title') . "'>" . ($navLink['title'] ?? 'title') . "</span>
                                                                    </a>
                                                                </li>";
                                                            }
                                                        }
                                                    echo "</ul>
                                                </div>";
                                            }
                                        echo "</li>";
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>

        <div class="sidebar-background"></div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0"><?= $this->title ?></h4>

                            <div class="page-title-right">
                                <?= Breadcrumbs::widget([
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]) ?>
                            </div>
                            <?php
                            /*
                            if (isset($this->params['breadcrumbs'])) {
                            ?>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <?= Breadcrumbs::widget([
                                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                        ]) ?>
                                    </ol>
                                </div>
                            <?php
                            }
                            */
                            ?>
                        </div>
                        <?= Alert::widget() ?>
                        <div class="row">
                            <div class="col">
                                <div class="h-100">
                                    <?= $content ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Trust Anchor Group.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by Trust Anchor Group
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->



<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

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

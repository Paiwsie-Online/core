<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */

/* @var $content string */

use backend\helpers\core\ContentHelper;
use backend\helpers\core\NotificationHelper;
use backend\helpers\core\TemplateHelper;
use backend\widgets\Alert;
use common\models\core\UserSetting;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use backend\assets\AppAsset;

$templateHelper = new TemplateHelper();
$contentHelper = new ContentHelper();

$this->registerJsFile(Yii::$app->request->baseUrl . '/js/custom.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/timeout.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/layout.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/simplebar/simplebar.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/node-waves/waves.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/libs/feather-icons/feather.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/app.js', ['depends' => [\yii\bootstrap5\BootstrapPluginAsset::class]]);
if (Yii::$app->params['default_site_settings']['use_notifications']) {
    $notificationHelper = new NotificationHelper();
    $this->registerJsFile(Yii::$app->request->baseUrl . '/js/notifications.js', ['depends' => [\yii\bootstrap5\BootstrapPluginAsset::class]]);
}

$this->registerCssFile(Yii::$app->request->baseUrl . '/libs/swiper/swiper-bundle.min.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/icons.min.css', ['depends' => [\yii\bootstrap5\BootstrapPluginAsset::class]]);
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/app.css', ['depends' => [\yii\bootstrap5\BootstrapPluginAsset::class]]);
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/custom.min.css', ['depends' => [\yii\bootstrap5\BootstrapPluginAsset::class]]);
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/project.css', ['depends' => [\yii\bootstrap5\BootstrapPluginAsset::class]]);


AppAsset::register($this);

$theme = Yii::$app->params['default_site_settings']['default_theme'];
if (Yii::$app->params['default_site_settings']['allow_theme_switch']) {
    $userTheme = UserSetting::findOne(['user_id' => Yii::$app->user->identity->id, 'setting' => 'theme']);
    if (isset($userTheme) && in_array($userTheme->value, ['light', 'dark'])) {
        $theme = $userTheme->value;
    }
}
$sidebarSize = 'lg';
$sidebarSetting = UserSetting::findOne(['user_id' => Yii::$app->user->identity->id, 'setting' => 'sidebar-size']);
if (isset($sidebarSetting) && in_array($sidebarSetting->value, ['lg', 'sm'])) {
    $sidebarSize = $sidebarSetting->value;
}
?>


<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?=$sidebarSize?>" data-sidebar-image="none" data-layout-mode="<?= $theme ?>">

<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <?php $this->registerCsrfMetaTags() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name='logoutTimer' content='<?=(Yii::$app->session->get('__expire') - time())?>'>
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= (Yii::$app->params['branding']['favicon'] ?? '/img/favicon.ico') ?>">
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
                            <img src="<?= (Yii::$app->params['branding']['smallLogo'] ?? '/img/logo-sm.png') ?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?= (Yii::$app->params['branding']['darkLogo'] ?? '/img/logo-dark.png') ?>" alt="" height="17">
                        </span>
                        </a>

                        <a href="/site/index" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?= (Yii::$app->params['branding']['smallLogo'] ?? '/img/logo-sm.png') ?>" alt="" height="22">
                        </span>
                            <span class="logo-lg">
                            <img src="<?= (Yii::$app->params['branding']['lightLogo'] ?? '/img/logo-light.png') ?>" alt="aaa" height="17">
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

                </div>

                <div class="d-flex align-items-center">

                    <?php
                    // Flags
                    $templateHelper->languageSelect();

                    if (Yii::$app->params['default_site_settings']['allow_theme_switch']) {
                        echo '<div class="ms-1 header-item d-none d-sm-flex">';
                        echo Html::a('<i class="bx bx-'.($theme === 'light'?'moon':'sun').' fs-22"></i>', ['/user-setting/set', 'setting' => 'theme', 'value' => ($theme === 'light'?'dark':'light')], ['data' => ['method' => 'post'], 'class' => 'btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none']);
                        echo '</div>';
                    }
                    if (Yii::$app->params['default_site_settings']['use_notifications']) {
                        echo '<div id="notificationBell">';
                        // Notifications/Messages
                        echo $notificationHelper->alertBell();
                        echo '</div>';
                    }
                    ?>

                    <?php
                    // User Profile
                    $templateHelper->userMenu($contentHelper->userMenuContent());
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
                    <img src="<?= (Yii::$app->params['branding']['smallLogo'] ?? '/img/logo-sm.png') ?>" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= (Yii::$app->params['branding']['darkLogo'] ?? '/img/logo-dark.png') ?>" alt="" height="17">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="/site/index" class="logo logo-light">
                <span class="logo-sm">
                    <img src="<?= (Yii::$app->params['branding']['smallLogo'] ?? '/img/logo-sm.png') ?>" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= (Yii::$app->params['branding']['lightLogo'] ?? '/img/logo-dark.png') ?>" alt="" height="17">
                </span>
            </a>
            <a href="" type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </a>

        </div>

        <div id="scrollbar">
            <div class="container-fluid">

                <div id="two-column-menu">
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <?php
                    $templateHelper->organizationSelection();

                    /*Print out navigation menu*/
                    $templateHelper->mainNavigation($contentHelper->mainMenuContent());
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
                        <?=date('Y')?> © <?= Yii::$app->params['branding']['copyright'] ?>
                    </div>
                    <div class="col-sm-6">
                            <?php $templateHelper->footerMenu($contentHelper->footerMenuContent()) ?>
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

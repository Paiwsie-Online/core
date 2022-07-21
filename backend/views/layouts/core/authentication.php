<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/custom.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/libs/simplebar/simplebar.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/libs/node-waves/waves.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/libs/feather-icons/feather.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/pages/plugins/lord-icon-2.1.0.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/plugins.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJsFile(Yii::$app->request->baseUrl.'/libs/particles.js/particles.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/pages/particles.app.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/pages/password-addon.init.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/layout.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile(Yii::$app->request->baseUrl.'/css/icons.min.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/app.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/custom.min.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/project.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);

$this->title = Yii::$app->params['default_site_settings']['site_name'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" data-theme="light" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
        <head>

            <meta charset="<?= Yii::$app->charset ?>" />
            <?php $this->registerCsrfMetaTags() ?>
            <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
            <meta name="description" content="">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
            <title><?= Html::encode($this->title) ?></title>

            <?php $this->head() ?>
        </head>
        <body>

            <div class="auth-page-wrapper pt-5">
                <!-- auth page bg -->
                <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
                    <div class="bg-overlay"></div>

                    <div class="shape">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                            <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                        </svg>
                    </div>
                </div>

                <!-- auth page content -->
                <div class="auth-page-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center mt-sm-5 mb-4 text-white-50">
                                    <div>
                                        <a href="/site/index" class="d-inline-block auth-logo">
                                            <img src="/img/logo-light.png" alt="" height="20">
                                        </a>
                                    </div>
                                    <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-6 col-xl-5">
                                <div class="card mt-4">

                                    <div class="card-body p-4">
                                        <?php echo $content ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- end row -->

                </div>
                <footer class="footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <p class="mb-0 text-muted">&copy;
                                        <script>document.write(new Date().getFullYear())</script> Trust Anchor Group.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>


    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
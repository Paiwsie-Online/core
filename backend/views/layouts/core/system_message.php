<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */
/* @var $content string */

use backend\widgets\Alert;
use yii\helpers\Html;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/custom.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/libs/popper/popper.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/bootstrap.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/sidenav.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/pages/authentication.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/project.css');

$this->title = Yii::$app->params['default_site_settings']['site_name'];
$this->beginPage() ?>
    <!DOCTYPE html>
    <html class="light-style" lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <?php $this->registerCsrfMetaTags() ?>
        <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <title><?= Html::encode($this->title) ?></title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">
        <link rel="stylesheet" href="/fonts/fontawesome.css">
        <link rel="stylesheet" href="/fonts/ionicons.css">
        <link rel="stylesheet" href="/css/appwork.css">
        <link rel="stylesheet" href="/css/colors.css">
        <link rel="stylesheet" href="/css/uikit.css">
        <script src="/js/layout-helpers.js"></script>
        <link rel="stylesheet" href="/libs/perfect-scrollbar/perfect-scrollbar.css">
        <?php $this->head() ?>
    </head>
    <body>
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <?= Alert::widget() ?>
    <div class="authentication-wrapper authentication-2 ui-bg-cover ui-bg-overlay-container px-4" style="background-image: url(<?=Yii::$app->params['branding']['backgroundImage']?>);">
        <div class="ui-bg-overlay bg-dark opacity-25"></div>
        <div class="authentication-inner py-5">
            <div class="card">
                <div class="p-4 p-sm-5">
                    <?= $content ?>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
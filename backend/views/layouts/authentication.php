<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */
/* @var $content string */

use common\models\core\SystemContent;
use backend\widgets\Alert;
use backend\assets\AppAsset;
use Imagine\Image\ManipulatorInterface;
use yii\helpers\Html;

AppAsset::register($this);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/custom.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/libs/popper/popper.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/bootstrap.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/sidenav.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/pages/authentication.css');

$this->title = Yii::$app->params['default_site_settings']['site_name'];
?>
<?php $this->beginPage() ?>
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
    <div class="authentication-wrapper authentication-3">
        <div class="authentication-inner">
            <div class="d-none d-lg-flex col-7 align-items-center ui-bg-cover ui-bg-overlay-container p-5" style="background-image: url(<?=Yii::$app->params['branding']['backgroundImage']?>">
                <div class="ui-bg-overlay bg-dark opacity-50"></div>
                <div class="w-100 text-white px-5">
                    <h1 class="display-2 font-weight-bolder mb-4"><?=Yii::t('system_content', SystemContent::getContent('LoginHeader'))?></h1>
                    <div class="text-large font-weight-light">
                        <?=Yii::t('system_content', SystemContent::getContent('LoginHeaderContent'))?>
                    </div>
                </div>
            </div>
            <div class="theme-bg-white d-flex col-12 col-lg-5 align-items-center p-5">
                <div class="d-flex col-sm-7 col-md-5 col-lg-12 px-0 px-xl-4 mx-auto">
                    <div class="w-100">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="<?= Yii::$app->thumbnailer->get(Yii::$app->params['branding']['lightLogo'], 100, 100, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true)?>">
                        </div>
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
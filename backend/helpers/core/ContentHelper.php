<?php


namespace backend\helpers\core;


use Yii;

class ContentHelper
{
    public function mainMenuContent()
    {
        return require Yii::$app->basePath . '/config/navigations'.Yii::$app->params['navigations']['main'].'.php';
    }

    public function userMenuContent() {
        return require Yii::$app->basePath . '/config/navigations'.Yii::$app->params['navigations']['user'].'.php';
    }

    public function footerMenuContent() {
        return require Yii::$app->basePath . '/config/navigations'.Yii::$app->params['navigations']['footer'].'.php';
    }
}
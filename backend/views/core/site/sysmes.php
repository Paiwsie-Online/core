<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\helpers\Html;

if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    echo Yii::t('core_system', 'Something went wrong. Please try again') . '<br>'. Html::a(Yii::t('core_system', 'Continue'), '/site/loginemail', ['class' => 'btn btn-warning mt-4']);
}
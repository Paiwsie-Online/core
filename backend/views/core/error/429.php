<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = Yii::t('core_system', 'Too Many Requests (#429)');
?>

<div class="site-error">
    <h1><?= Html::encode($this->title) ?></h1><br>
    <p>
        <?=$exception->getMessage()?>
    </p>
</div>

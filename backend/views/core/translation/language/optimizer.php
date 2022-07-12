<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */

/* @var $this \yii\web\View */
/* @var $newDataProvider \yii\data\ArrayDataProvider */

$this->title = 'Optimise database';
$this->params['breadcrumbs'][] = ['label' => 'Languages', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="w2-info" class="alert-info alert fade in">
    <?= Yii::t('language', '{n, plural, =0{No entries} =1{One entry} other{# entries}} were removed!', ['n' => $newDataProvider->totalCount]) ?>
</div>

<?= $this->render('__scanNew', [
    'newDataProvider' => $newDataProvider,
]) ?>
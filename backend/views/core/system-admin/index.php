<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */

use yii\bootstrap4\Html;

?>

<div class="col-12 mb-4">
    <h2><?=Yii::t('core_system', 'System Maintenance')?></h2>
</div>
<div class="col-12">
    <div class="card mb-4">
        <div class="card-header">
            <h4><?=Yii::t('core_system','System')?></h4>
        </div>
        <div class="card-body borderTop">
            <div class="card mb-4 border-info">
                <div class="card-header cardHeader">
                    <h4><?=Yii::t('core_system','System administration')?></h4>
                </div>
                <div class="card-body borderTop cardContent">
                    <div class="mb-3">
                        <?=Yii::t('core_system','To flush the cache folder to force js / css / translation updates straight away press the button below')?>
                    </div>
                    <?= Html::a(Yii::t('core_system', 'Flush Cache'), ['flush-cache'], [
                        'class' => 'btn btn-warning',
                        'data' => [
                            'confirm' => Yii::t('core_system', 'Are you sure you want to flush system cache?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="card border-info">
                <div class="card-header cardHeader">
                    <h4><?=Yii::t('core_system','DB enum translations')?></h4>
                </div>
                <div class="card-body borderTop cardContent">
                    <?=Yii::t('core_system', 'The translations are in each corresponding model')?><br>
                    <?=Yii::t('core_system', 'The DB tables with translations in the added fields are in: / backend / config / main.php')?>
                </div>
            </div>
        </div>
    </div>
</div>
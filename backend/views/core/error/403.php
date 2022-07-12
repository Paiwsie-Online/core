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

$this->title = Yii::t('core_system', 'Access denied (#403)');
?>

<div class="col-12 mb-4">
    <h2><?=$this->title?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-body text-center">
            <img src="<?=Yii::$app->params['default_site_settings']['base_url']?>/img/access_denied.png" height="164" width="213"><br><br>
            <?=Yii::t('core_system', 'You do not have permission to do this action')?><br><br>
            <a class="btn btn-warning" href="/site/index"><?=Yii::t('core_system', 'Back to index')?></a>
        </div>
    </div>
</div>

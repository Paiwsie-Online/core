<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\bootstrap4\Html;

?>
<div class="site-user-invitation text-center">
    <h2><?= Yii::t('core_user', 'User invitation') ?></h2>
    <p>You have received an invitation to Smartadmin.
    <br>You could log in or register now.
    <br>If you want to access later click again in the received link.</p>
    <div class="row">
        <div class="col-md-6 p-3">
            <?= Html::a(Yii::t('core_system', 'Login'), ['loginemail'], ['class' => 'btn btn-block btn-success']) ?>
        </div>
        <div class="col-md-6 p-3">
            <?= Html::a(Yii::t('core_system', 'Register'), ['/user/register'], ['class' => 'btn btn-block btn-primary']) ?>
        </div>
    </div>
</div>

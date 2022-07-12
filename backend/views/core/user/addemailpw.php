<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */
/* @var $model common\models\core\User */

use common\models\core\User;
use Imagine\Image\ManipulatorInterface;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="row">
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="media">
                    <img src="<?= (isset($model->picture['uri']) ? Yii::$app->thumbnailer->get($model->picture['uri'], 100, 100, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) : '/img/avatars/1.png') ?>" alt="user profile picture" class="ui-w-100 rounded-circle">
                    <div class="media-body pt-2 ml-3">
                        <h5 class="mb-2"><?= User::getUserName($model->id) ?></h5>
                    </div>
                </div>
            </div>
            <hr class="border-light m-0">
            <?php $form = ActiveForm::begin([
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'options' => ['id' => 'pw_form']
            ]); ?>
            <br><div class="col-12">
                <?= $form->field($model, 'email', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true])->label(Yii::t('core_system', 'Email') . '*') ?>
            </div>
            <div class="col-12">
                <?= $form->field($model, 'temp_password', ['options' => ['class' => 'form-group']])->passwordInput(['maxlength' => true])->label(Yii::t('core_user', 'Password') . '*') ?>
            </div>
            <div class="col-12">
                <?= $form->field($model, 'retype_password', ['options' => ['class' => 'form-group']])->passwordInput(['maxlength' => true])->label(Yii::t('core_user', 'Retype Password') . '*') ?>
            </div>
            <div class="form-group text-right mr-3">
                <?= Html::a(Yii::t('core_system', 'Cancel'), ['profile-settings'], ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton(Yii::t('core_system', 'Save'), ['class' => 'btn btn-success', 'id' => 'submit_btn']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<h4 class="text-center text-lighter font-weight-normal mt-5 mb-5"><?=Yii::t('core_system', 'Reset Your Password')?></h4>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'id' => 'submitForm',
]); ?>
<div class="col-12">
    <?= $form->field($model, 'temp_password', ['options' => ['class' => 'form-group']])->passwordInput(['maxlength' => true])->label(Yii::t('core_user', 'New Password') . '*') ?>
    <?= $form->field($model, 'retype_password', ['options' => ['class' => 'form-group']])->passwordInput(['maxlength' => true])->label(Yii::t('core_user', 'Retype Password') . '*') ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('core_system','Save'), ['id' => 'submitButton', 'class' => 'btn btn-block btn-success']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<br>
<div class="col-md-12 text-center">
    <?= Html::a(Yii::t('core_system', 'Go to Login'), (isset($model->email) ? '/site/loginemail' : '/site/login-mobile'), ['class' => 'btn btn-primary']) ?>
</div>
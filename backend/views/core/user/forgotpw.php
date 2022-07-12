<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<h4 class="text-center text-lighter font-weight-normal mt-5 mb-5"><?=Yii::t('core_system', 'Forgot Your Password')?></h4>
<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'id' => 'submitForm',
]); ?>
<div class="col-md-12">
    <label for="forgotpw-email"><?=Yii::t('core_system', 'Email') . '*'?></label>
    <?= Html::input('email', 'email', '', [
        'maxlength' => 256,
        'id' => 'forgotpw-email',
        'class' => 'form-control',
        'placeholder' => Yii::t('core_user', 'Type in your registered email address'),
    ]); ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('core_system','Send email'), ['id' => 'submitButton', 'class' => 'btn btn-block btn-success']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<br>
<div class="col-md-12 text-center">
    <?= Html::a(Yii::t('core_system', 'Back to Login'), '/site/loginemail', ['class' => 'btn btn-primary']) ?>
</div>
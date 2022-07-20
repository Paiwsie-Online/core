<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $model common\models\core\User */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
?>

<h4 class="text-center text-lighter font-weight-normal mt-5 mb-5"><?=Yii::t('core_system', 'Register a New Account')?></h4>
<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'id' => 'submitForm',
]); ?>
<div class="row">
    <?= $form->field($model, 'email', ['options' => ['class' => 'form-group col-12']])->textInput(['maxlength' => true])->label(Yii::t('core_system', 'Email') . '*') ?>
    <?= $form->field($model, 'first_name', ['options' => ['class' => 'form-group col-12']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'last_name', ['options' => ['class' => 'form-group col-12']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'temp_password', ['options' => ['class' => 'form-group col-12']])->passwordInput(['maxlength' => true])->label(Yii::t('core_user', 'Password') . '*') ?>
    <?= $form->field($model, 'retype_password', ['options' => ['class' => 'form-group col-12']])->passwordInput(['maxlength' => true])->label(Yii::t('core_user', 'Retype Password') . '*') ?>
</div>

<div class="form-group">
    <?= Html::submitButton(Yii::t('core_system', 'Register'), ['id' => 'submitButton', 'class' => 'btn btn-success w-100 mt-3']) ?>
</div>

<?php ActiveForm::end(); ?>
<div class="mt-3 text-center">
    <div class="signin-other-title">
        <h5 class="fs-13 mb-2 title"><?= Yii::t('core_system', 'Signup with') ?></h5>
    </div>
    <div>
        <?= (Yii::$app->params['loginOptions']['allowPhone'] ? '
                <a href="login-mobile" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-phone-fill fs-16"></i></a>': '') ?>
        <?= (Yii::$app->params['loginOptions']['allowQR'] ? '
                <a href="loginqr" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-qr-code-line fs-16"></i></a>': '') ?>
    </div>
</div>
<div class="col-md-12 text-center mt-4">
    <?= Html::a(Yii::t('core_system', 'Back to Login'), '/site/loginemail', ['class' => 'btn btn-primary']) ?>
</div>
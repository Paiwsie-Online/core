<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $model common\models\core\User */

use borales\extensions\phoneInput\PhoneInput;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>

<div class="text-center mt-2">
    <h5 class="text-primary"><?= Yii::t('core_system', 'Welcome!') ?></h5>
    <p class="text-muted"><?= Yii::t('core_system', 'Sign up to '). Yii::$app->params['default_site_settings']['site_name']?></p>
</div>
<div class="p-2 mt-4">
<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'id' => 'submitForm',
]); ?>
<div class="mb-3">
        <?=$form->field($model, 'phone')->widget(PhoneInput::className(), [
            'options'   =>  [
                'class' => 'form-control form-group',
            ],
            'jsOptions' => [
                'preferredCountries' => Yii::$app->params['inputSettings']['phoneInput']['preferredCountries'],
                'onlyCountries'     =>  Yii::$app->params['inputSettings']['phoneInput']['onlyCountries'],
            ]
        ])?>
</div>
    <div class="mb-3">
    <?= $form->field($model, 'first_name', ['options' => ['class' => 'form-group col-12']])->textInput(['maxlength' => true]) ?>
    </div>
    <div class="mb-3">
    <?= $form->field($model, 'last_name', ['options' => ['class' => 'form-group col-12']])->textInput(['maxlength' => true]) ?>
    </div>
    <div class="mb-3">
    <?= $form->field($model, 'temp_password', ['options' => ['class' => 'form-group col-12']])->passwordInput(['maxlength' => true])->label(Yii::t('core_user', 'Password') . '*') ?>
    <?= $form->field($model, 'retype_password', ['options' => ['class' => 'form-group col-12']])->passwordInput(['maxlength' => true])->label(Yii::t('core_user', 'Retype Password') . '*') ?>
    </div>

    <div class="mt-4">
        <?= Html::submitButton(Yii::t('core_system', 'Sign Up'), ['id' => 'submitButton', 'class' => 'btn btn-success w-100 mb-3', 'name' => 'register-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>
<div class="mt-3 text-center">
    <div class="signin-other-title">
        <h5 class="fs-13 mb-2 title"><?= Yii::t('core_system', 'Signup with') ?></h5>
    </div>
    <div>
        <?= (Yii::$app->params['loginOptions']['allowEmail'] ? '
                <a href="/user/register" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-mail-fill fs-16"></i></a>': '') ?>
        <?= (Yii::$app->params['loginOptions']['allowQR'] ? '
                <a href="/site/loginqr" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-qr-code-line fs-16"></i></a>': '') ?>
    </div>
</div>

<div class="mt-4 text-center">
    <p class="mb-0"><?= Yii::t('core_system', 'Already signed up?') ?>  <a href="/site/login" class="fw-semibold text-primary text-decoration-underline"> <?= Yii::t('core_system', 'Sign in') ?> </a> </p>
</div>
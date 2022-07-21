<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */
/* @var $model common\models\core\LoginForm */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="text-center mt-2">
    <h5 class="text-primary"><?= Yii::t('core_system', 'Welcome Back !') ?></h5>
    <p class="text-muted"><?= Yii::t('core_system', 'Sign in to continue to '). Yii::$app->params['default_site_settings']['site_name']?></p>
</div>
<div class="p-2 mt-4">
    <?php
    $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
    ]);
    ?>

        <div class="mb-3">
            <?= $form->field($model, 'email')->textInput(['autofocus' => false]) ?>
        </div>

        <div class="mb-3">
            <div class="float-end">
                <?= Html::a(Yii::t('core_system', 'Forgot password?'), '/user/forgotpw', ['class' => 'text-muted']) ?>
            </div>
            <label class="form-label" for="password-input">Password</label>

            <div class="position-relative auth-pass-inputgroup mb-3">
                <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control pe-5'])->label(false) ?>
                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
            </div>

        </div>

        <div class="mt-4">
            <?= Html::submitButton(Yii::t('core_system', 'Sign In'), ['class' => 'btn btn-success w-100 mb-3', 'name' => 'login-button']) ?>
        </div>

        <div class="mt-3 text-center">
            <div class="signin-other-title">
                <h5 class="fs-13 mb-2 title"><?= Yii::t('core_system', 'Or sign in with') ?></h5>
            </div>
            <div>
                <?= (Yii::$app->params['loginOptions']['allowPhone'] ? '
                <a href="/site/login-mobile" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-phone-fill fs-16"></i></a>': '') ?>
                <?= (Yii::$app->params['loginOptions']['allowQR'] ? '
                <a href="/site/loginqr" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-qr-code-line fs-16"></i></a>': '') ?>
            </div>
        </div>

    <?php
    ActiveForm::end();
    ?>
</div>
<div class="mt-4 text-center">
    <p class="mb-0"><?= Yii::t('core_system', 'Don\'t have an account yet?') ?>  <a href="/user/register" class="fw-semibold text-primary text-decoration-underline"> <?= Yii::t('core_system', 'Sign up') ?> </a> </p>
</div>

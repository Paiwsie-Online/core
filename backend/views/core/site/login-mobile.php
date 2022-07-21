<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */
/* @var $model common\models\core\LoginForm */

use borales\extensions\phoneInput\PhoneInput;
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
/*TODO: look over the design of phone input see if we can make it match other inputs*/
?>
<?=$form->field($model, 'phone')->widget(PhoneInput::className(), [
    'options'   =>  [
        'class' => 'form-control form-group',
    ],
    'jsOptions' => [
        'preferredCountries' => Yii::$app->params['inputSettings']['phoneInput']['preferredCountries'],
        'onlyCountries'     =>  Yii::$app->params['inputSettings']['phoneInput']['onlyCountries'],
    ]
])?>
<?= $form->field($model, 'password2')->passwordInput() ?>
<div class="form-group row">
    <div class="col-md-12">
        <?= Html::submitButton(Yii::t('core_system', 'Login'), ['class' => 'btn w-100 btn-success', 'name' => 'login-button']) ?>
    </div>
</div>
    <div class="mt-3 text-center">
        <div class="signin-other-title">
            <h5 class="fs-13 mb-2 title"><?= Yii::t('core_system', 'Or sign in with') ?></h5>
        </div>
        <div>
            <?= (Yii::$app->params['loginOptions']['allowEmail'] ? '
                <a href="/site/loginemail" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-mail-fill fs-16"></i></a>': '') ?>
            <?= (Yii::$app->params['loginOptions']['allowQR'] ? '
                <a href="/site/loginqr" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-qr-code-line fs-16"></i></a>': '') ?>
        </div>
    </div>

<?php
ActiveForm::end();
?>
</div>
<div class="mt-4 text-center">
    <p class="mb-0"><?= Yii::t('core_system', 'Don\'t have an account yet?') ?>  <a href="/user/register-mobile" class="fw-semibold text-primary text-decoration-underline"> <?= Yii::t('core_system', 'Sign up') ?> </a> </p>
</div>
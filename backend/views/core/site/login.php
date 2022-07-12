<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */
/* @var $model common\models\core\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<h4 class="text-center text-lighter font-weight-normal mt-5 mb-5"><?=Yii::t('core_system', 'Sign in to Your Account')?></h4>
<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
]);
?>
<?= $form->field($model, 'email')->textInput(['autofocus' => false]) ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<div class="form-group row">
    <div class="col-md-12">
        <?= Html::submitButton(Yii::t('core_system', 'Login'), ['class' => 'btn btn-block btn-success', 'name' => 'login-button']) ?>
    </div>
</div>
<div class="row mb-5">
    <?php
    if (Yii::$app->params['loginOptions']['allowEmail'] || Yii::$app->params['loginOptions']['allowPhone']) {
        ?>
        <div class="<?=(Yii::$app->params['loginOptions']['allowEmail'] && Yii::$app->params['loginOptions']['allowPhone'] ? 'col-md-8' : 'col-md-6')?>">
            <?php
            if (Yii::$app->params['loginOptions']['allowEmail']) {
                ?>
                <a href="<?=Url::to(['user/register'])?>" role="button" class="btn btn-primary <?=(Yii::$app->params['loginOptions']['allowEmail'] && Yii::$app->params['loginOptions']['allowPhone'] ? 'mr-4' : 'btn-block')?>">
                    <?=Yii::t('core_system', 'Register with email')?></a>
                <?php
            }
            if (Yii::$app->params['loginOptions']['allowPhone']) {
                ?>
                <a href="<?=Url::to(['user/register-mobile'])?>" role="button" class="btn btn-primary <?=(Yii::$app->params['loginOptions']['allowEmail'] && Yii::$app->params['loginOptions']['allowPhone'] ? 'ml-3' : 'btn-block')?>">
                    <?=Yii::t('core_system', 'Register with phone')?></a>
                <?php
            }
            ?>
        </div>
        <div class="<?=(Yii::$app->params['loginOptions']['allowEmail'] && Yii::$app->params['loginOptions']['allowPhone'] ? 'col-md-4' : 'col-md-6')?>">
        <?php
    }

    ?>
        <a href="<?=Url::to(['user/forgotpw'])?>" role="button" class="btn btn-block btn-warning">
            <?=Yii::t('core_system', 'Forgot my password')?></a>
    </div>
</div>
<?php
ActiveForm::end();

if (Yii::$app->params['loginOptions']['allowQR'] || Yii::$app->params['loginOptions']['allowPhone']) {
?>
    <div class="row">
        <div class="col-md-12 text-center mb-4">
            <p class="text_white">
                <?php
                if (Yii::$app->params['loginOptions']['allowQR'] && Yii::$app->params['loginOptions']['allowPhone']) {
                    echo Yii::t('core_system', 'Or you can login scanning QRCode with TagID app or Phone.');
                } elseif (Yii::$app->params['loginOptions']['allowPhone']) {
                    echo Yii::t('core_system', 'Or you can login scanning QRCode with Phone.');
                } elseif (Yii::$app->params['loginOptions']['allowQR']) {
                    echo Yii::t('core_system', 'Or you can login scanning QRCode with TagID app.');
                }
                ?>
            </p>
        </div>
        <div class="col-md-12 text-center">
            <?php
            if (Yii::$app->params['loginOptions']['allowQR']) {
                echo Html::a(Yii::t('core_system', 'QR Login'), 'loginqr', ['class' => 'btn btn-primary mr-3']);
            }
            if (Yii::$app->params['loginOptions']['allowPhone']) {
                echo Html::a(Yii::t('core_system', 'Phone Login'), 'login-mobile', ['class' => 'btn btn-primary']);
            }
            ?>
        </div>
    </div>
<?php
}
?>
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $model common\models\core\User */

use yii\bootstrap4\ActiveForm;
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

<div class="form-group mb-5">
    <?= Html::submitButton(Yii::t('core_system', 'Register'), ['id' => 'submitButton', 'class' => 'btn btn-block btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
<div class="col-md-12 text-center">
    <?= Html::a(Yii::t('core_system', 'Back to Login'), '/site/loginemail', ['class' => 'btn btn-primary']) ?>
</div>
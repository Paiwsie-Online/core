<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $model common\models\core\User */

use borales\extensions\phoneInput\PhoneInput;
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
    <?=$form->field($model, 'phone')->widget(PhoneInput::className(), [
        'options'   =>  [
            'class' => 'form-control form-group',
        ],
        'jsOptions' => [
            'preferredCountries' => Yii::$app->params['inputSettings']['phoneInput']['preferredCountries'],
            'onlyCountries'     =>  Yii::$app->params['inputSettings']['phoneInput']['onlyCountries'],
        ]
    ])?>
    <br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('core_system','Send sms'), ['id' => 'submitButton', 'class' => 'btn btn-block btn-success']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<br>
<div class="col-md-12 text-center">
    <?= Html::a(Yii::t('core_system', 'Back to Login'), '/site/login-mobile', ['class' => 'btn btn-primary']) ?>
</div>
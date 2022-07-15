<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $model common\models\Athlete */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

foreach ($model->participantLevels() as $participantLevel) {
    echo $participantLevel->value;
}


?>

<h4 class="text-center text-lighter font-weight-normal mt-5 mb-5"><?=Yii::t('core_system', 'Add a new athlete')?></h4>
<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    //'id' => 'submitForm',
]); ?>
<div class="row">
    <?= $form->field($model, 'first_name', ['options' => ['class' => 'form-group col-12']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'last_name', ['options' => ['class' => 'form-group col-12']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'team', ['options' => ['class' => 'form-group col-12']])->dropdownList(Yii::$app->user->identity->teamList, ['prompt' => ['text' => Yii::t('core_system', 'Select team'), 'options' => ['disabled' => true, 'selected' => true]]])->label(Yii::t('core_organization', 'Team') . '*') ?>
</div>

<div class="form-group mb-5">
    <?= Html::submitButton(Yii::t('core_system', 'Add athlete'), ['id' => 'submitButton', 'class' => 'btn btn-block btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
<!--<div class="col-md-12 text-center">
    <?php /*echo Html::a(Yii::t('core_system', 'Back to Login'), '/site/loginemail', ['class' => 'btn btn-primary']) */?>
</div>-->
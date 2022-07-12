<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\ApiKey;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\core\ApiKey */

$this->title = Yii::t('core_system', 'Create Api Key');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_system', 'Api Keys'), 'url' => ['index-site-admin']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/pageScripts/apiKeyCreate.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_system', 'Create Api Key')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="ml-3"><?=Yii::t('core_system', 'New Api Key')?></h4>
        </div>
        <div class="card-body borderTop">
            <?php $form = ActiveForm::begin() ?>
            <div class="col-md-6">
                <?=$form->field($model, 'type')->dropdownList(ApiKey::getType(), ['prompt' => ['text' => Yii::t('core_system', 'Select Type'), 'options' => ['disabled' => true, 'selected' => true]]])?>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-check mt-3 mb-5"><input class="form-check-input expiryDateCheckbox" id="expiryDateCheckbox" type="checkbox" onclick="showExpiryDate()"><div class="form-check-label"><?=Yii::t('core_system', 'Expiry Date')?></div></label>
                    </div>
                    <div class="col-md-8" id="expiry_date">
                        <?=$form->field($model, 'expiry_date')->widget(DatePicker::className(), ['options' => ['class' => 'form-control'], 'dateFormat' => 'yyyy-MM-dd'])->label(false)?>
                    </div>
                </div>
                <?= Html::submitButton(Yii::t('core_system', 'Create'), ['class' => 'btn btn-warning']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
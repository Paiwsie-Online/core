<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\Enumeration;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\Enumeration */

$this->title = Yii::t('core_system', 'Create Enumeration');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_system', 'Enumerations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/pageScripts/enumerationCreate.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=Yii::t('core_system', 'New Enumeration')?></h4>
        </div>
        <div class="card-body borderTop">
            <?php $form = ActiveForm::begin() ?>
            <div class="col-md-6">
                <?php
                $itemList = \yii\helpers\ArrayHelper::map(Enumeration::getEnumerators(), 'enumerator', 'enumerator');
                ?>
                <?=Yii::t('core_model', 'Enumerator')?><?=Html::a('+ ' . Yii::t('core_system', 'Add Enumerator'), ['newenumerator'], ['class' => 'site-modal-link btn btn-sm btn-warning float-right text-dark mb-2', 'data-modalTitle' => Yii::t('core_system', 'New Enumerator')])?>
                <?=$form->field($model, 'enumerator')->dropdownList($itemList, ['prompt' => ['text' => Yii::t('core_system', 'Select Enumerator'), 'options' => ['disabled' => true, 'selected' => true]]])->label(false)?>
                <input type="hidden" name="parentId" id="parentId">
                <label><?=Yii::t('core_model', 'Parent')?></label>
                <input type="text" id="parent" class="form-control" autocomplete="off">
                <ul class="list-group list-group-flush" id="searchParentList" style="overflow-y: scroll; max-height: 180px">
                </ul>
                <?=$form->field($model, 'value', ['options' => ['class' => 'mt-3']])->textArea()?>
                <?= Html::submitButton(Yii::t('core_system', 'Create'), ['class' => 'btn btn-warning mt-3']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

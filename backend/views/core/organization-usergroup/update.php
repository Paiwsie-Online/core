<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\core\OrganizationUsergroup */

$this->title = Yii::t('core_organization', 'Change group name: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', '{organization} user groups', ['organization' => Yii::$app->user->identity->selectedOrganization['name']]), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('core_organization', 'Change group name');
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_organization', 'Change group name')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="ml-2"><?=$model->name?></h4>
        </div>
        <div class="card-body borderTop">
            <?php $form = ActiveForm::begin() ?>
            <div class="organization-usergroup-update">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= Html::submitButton(Yii::t('core_organization', 'Change group name'), ['class' => 'btn btn-warning']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
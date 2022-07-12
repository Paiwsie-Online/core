<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\core\OrganizationUsergroup */

$this->title = Yii::t('core_organization', 'Create User group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', '{organization} user groups', ['organization' => Yii::$app->user->identity->selectedOrganization['name']]), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="ml-2"><?=Yii::t('core_organization', 'New Group')?></h4>
        </div>
        <div class="card-body borderTop">
            <?php $form = ActiveForm::begin() ?>
            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= Html::submitButton('+ ' . Yii::t('core_organization', 'Create User Group'), ['class' => 'btn btn-warning']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
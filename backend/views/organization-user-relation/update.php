<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\OrganizationUserRelation;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\core\OrganizationUserRelation */

$user = User::findIdentity($model->user_id);

$this->title = Yii::t('core_system', 'Update'). ': ' . $user->first_name . ' ' . $user->last_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', '{organization} users', ['organization' => Yii::$app->user->identity->selectedOrganization['name']]), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $user->first_name . ' ' . $user->last_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('core_system', 'Update');
?>
<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_system', 'Update')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="ml-2"><?=$user->first_name . ' ' . $user->last_name?></h4>
        </div>
        <div class="card-body borderTop">
            <?php $form = ActiveForm::begin() ?>
            <div class="organization-user-relation-update">
                <div class="col-md-6">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'user_level')->dropdownList(OrganizationUserRelation::getUserLevelOptions()) ?>
                    <?= Html::submitButton(Yii::t('core_system', 'Update'), ['class' => 'btn btn-warning']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


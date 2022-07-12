<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\core\OrganizationUsergroupUserRelation */
/* @var $parentModel common\models\core\OrganizationUsergroup */

$this->title = Yii::t('core_organization', 'Add user');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', '{organization} user groups', ['organization' => Yii::$app->user->identity->selectedOrganization['name']]), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $parentModel->name, 'url' => ['view?id=' . $parentModel->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_organization', 'Add User')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="ml-2"><?=Html::encode($parentModel->name)?></h4>
        </div>
        <div class="card-body borderTop">
            <?php $form = ActiveForm::begin([
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'validateOnBlur' => false,
                'validateOnChange' => false,
                'validateOnSubmit' => true,]) ?>
            <div class="col-md-6">
                <?= $form->field($model, 'ou_relation_id')->dropdownList(Yii::$app->user->identity->selectedOrganization->userListAddUserListRelation, ['prompt' =>  Yii::t('core_system', 'Select User'), 'options' => Yii::$app->user->identity->selectedOrganization->getUserListAddUserListRelationDisabled($parentModel->id)]) ?>
                <?= Html::submitButton('+ ' . Yii::t('core_organization', 'Add User'), ['class' => 'btn btn-warning']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
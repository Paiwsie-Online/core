<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\Organization;
use common\models\core\OrganizationUserRelation;
use common\models\core\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\core\OrganizationUsergroupUserRelation */
/* @var $parentModel common\models\core\OrganizationUserRelation */

$user = User::findIdentity($parentModel->user_id);

$this->title = Yii::t('core_organization', 'Add group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', '{organization} users', ['organization' => Yii::$app->user->identity->selectedOrganization['name']]), 'url' => ['/organization-user-relation/list']];
$this->params['breadcrumbs'][] = ['label' => $user->first_name . ' ' . $user->last_name, 'url' => ['/organization-user-relation/view?id=' . $parentModel->id]];
$this->params['breadcrumbs'][] = $this->title;

$organization_id = OrganizationUserRelation::getSelectedOrganization()->organization_id;
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Html::encode($this->title)?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="ml-2"><?=$user->first_name . ' ' . $user->last_name?></h4>
        </div>
        <div class="card-body borderTop">
            <?php $form = ActiveForm::begin([
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'validateOnBlur' => false,
                'validateOnChange' => false,
                'validateOnSubmit' => true,]) ?>
            <div class="col-md-6">
                <?= $form->field($model, 'group_id')->dropDownList(Organization::getGroupsByOrganization($organization_id), ['prompt' => Yii::t('core_system', 'Select Group'), 'options' => Organization::getGroupsByOrganizationDisabled($parentModel->id), 'required' => true])?>
                <?= Html::submitButton('+ ' . Yii::t('core_organization', 'Add group'), ['class' => 'btn btn-warning']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\OrganizationUserRelation;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\OrganizationUserRelation */
/* @var $parentModel common\models\core\OrganizationUserRelationInvitation */


$this->title = Yii::t('core_organization', 'Invite user');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', '{organization} users', ['organization' => Yii::$app->user->identity->selectedOrganization['name']]), 'url'  =>  'list'];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/pageScripts/organizationInvite.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?= Yii::t('core_organization', 'Invite user')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="ml-2"><?=Yii::$app->user->identity->selectedOrganization['name']?></h4>
        </div>
        <div class="card-body borderTop">
            <?php $form = ActiveForm::begin() ?>
            <div class="col-md-6 mb-2">
                <?= $form->field($parentModel, 'sent_to')->input('email', ['id' => 'organizationuserrelationinvitation-input-Email', 'required'])->label(Yii::t('core_organization', 'Send invitation to email') . '*') ?>
                <?= $form->field($model, 'user_level')->dropdownList(OrganizationUserRelation::getUserLevelOptions(), ['prompt' => ['text' => Yii::t('core_system', 'Select user level'), 'options' => ['disabled' => true, 'selected' => true]]])->label(Yii::t('core_organization', 'Invite user as') . '*') ?>
                <?= $form->field($model, 'title')->label(Yii::t('core_organization', 'Users title within the organization, example CEO, Developer etc.') . '*') ?>
                <h5><?= Yii::t('core_organization', '{numGroups, plural, =0{There are no groups to add a user to.} =1{Add user to group} other{Add user to groups}}', ['numGroups' => count(Yii::$app->user->identity->selectedOrganization->organizationUsergroups)]) ?></h5>
                <?php
                foreach (Yii::$app->user->identity->selectedOrganization->organizationUsergroups as $userGroup) {
                    echo "<label class='form-check'><input class='form-check-input usergroupCheckbox' type='checkbox' value='{$userGroup->id}' name='usergroup[]'><div class='form-check-label'>{$userGroup->name}</div></label>";
                }
                ?>
                <?= $form->field($parentModel,'invite_params')->textarea(['rows' => '6', 'readonly' => true, 'style' => 'display:none'])->label(false) ?>
                <?= $form->field($parentModel, 'sent_via')->hiddenInput(['value' => 'email'])->label(false) ?>
                <?= Html::submitButton('+ ' . Yii::t('core_organization', 'Invite user'), ['class' => 'btn btn-warning']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
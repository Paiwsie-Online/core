<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */
/* @var $model common\models\core\OrganizationSetting */

use dosamigos\ckeditor\CKEditor;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', 'Organization Settings')];
\yii\web\YiiAsset::register($this);

$this->registerJsFile('@web/js/pageScripts/organizationSettingsContent.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_organization', 'Organization Settings')?></h2>
</div>
<div class="col-12">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <?=Yii::$app->uiComponent->organizationSettingsSidebar()?>
            </div>
        </div>
        <div class="col-md-9">
            <?php
            $form = ActiveForm::begin();
            ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?=Yii::t('core_system', 'Content')?></h4>
                </div>
                <div class="card-body borderTop">
                    <div class="row">
                        <div class="col-md-3 mt-2">
                            <a class="btn buttonTransparent mb-1 aNotCss" id="global"><?=Yii::t('core_system', 'Global')?></a><br>
                            <a class="btn buttonTransparent mb-1 aNotCss" id="inviteUser"><?=Yii::t('core_organization', 'Invite User')?></a><br>
                        </div>
                        <div class="col-md-9">
        <!-- GLOBAL -->
                            <div class="col-12" id="globalDiv">
                                <div class="card border-info">
                                    <div class="card-header cardHeader">
                                        <span class="float-right">

                                        </span>
                                        <h5><?=Yii::t('core_email', 'Email Signature')?></h5>
                                    </div>
                                    <div class="card-body cardContent borderTop">
                                        <?= $form->field($model, 'signature')->widget(CKEditor::className(), [
                                            'options' => ['rows' => 6],
                                            'preset' => 'custom',
                                            'clientOptions' => [
                                                'toolbarGroups' => [
                                                    ['name' => 'basicstyles', 'groups' => ['styles', 'basicstyles', 'cleanup']],
                                                    ['name' => 'lists', 'groups' => ['list']],
                                                    ['name' => 'links', 'groups' => ['links']],
                                                ]
                                            ]])->label(false) ?>
                                    </div>
                                </div>
                            </div>
        <!-- INVITE USER -->
                            <div class="col-12" id="inviteUserDiv" style="display: none">
                                <div class="card border-info mb-4">
                                    <div class="card-header cardHeader">
                                        <span class="float-right">

                                        </span>
                                        <h5><?=Yii::t('core_email', 'Invite User Email')?></h5>
                                    </div>
                                    <div class="card-body cardContent borderTop">
                                        <label><small class="text-muted poppinsStrong"><?=Yii::t('core_system', 'You can use the following variables')?>: {platformName}, {inviterName}, {organizationName}, {userLevel}</small></label>
                                        <?= $form->field($model, 'inviteUser')->widget(CKEditor::className(), [
                                            'options' => ['rows' => 6],
                                            'preset' => 'custom',
                                            'clientOptions' => [
                                                'toolbarGroups' => [
                                                    ['name' => 'basicstyles', 'groups' => ['styles', 'basicstyles', 'cleanup']],
                                                    ['name' => 'lists', 'groups' => ['list']],
                                                    ['name' => 'links', 'groups' => ['links']],
                                                ]
                                            ]])->label(false) ?>
                                    </div>
                                </div>
                                <?php
                                ?>
                            </div>
                        </div>
                        <?=Html::submitButton(Yii::t('core_system','Save Changes'), ['id' => 'submitButton', 'class' => 'btn btn-warning ml-3 mt-3'])?>
                    </div>
                </div>
            </div>
            <?php
            ActiveForm::end();
            ?>
        </div>
    </div>
</div>
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */
/* @var $model common\models\core\OrganizationSetting */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', 'Organization Settings')];
\yii\web\YiiAsset::register($this);

if (isset($model)) {
    $valueDecoded = json_decode($model->value);
}
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
                    <span class="float-right mt-1">
                        <?= Html::submitButton(Yii::t('core_system','Save'), ['id' => 'submitButton', 'class' => 'btn btn-block btn-warning']); ?>
                    </span>
                    <h4><?=Yii::t('core_system', 'Bank Info')?></h4>
                </div>
                <div class="card-body borderTop">
                    <div class="row mb-3">
                        <div class="col-md-3 mt-2">
                            <label for="bank_name"><?=Yii::t('core_organization', 'Bank Name')?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="bank_name" class="form-control" maxlength="256" value="<?=($valueDecoded->bank_name ?? '')?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 mt-2">
                            <label for="clearing_number"><?=Yii::t('core_organization', 'Clearing Number')?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="clearing_number" class="form-control" maxlength="128" value="<?=($valueDecoded->clearing_number ?? '')?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 mt-2">
                            <label for="account_number"><?=Yii::t('core_organization', 'Account Number')?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="account_number" class="form-control" maxlength="128" value="<?=($valueDecoded->account_number ?? '')?>" required>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            ActiveForm::end();
            ?>
        </div>
    </div>
</div>
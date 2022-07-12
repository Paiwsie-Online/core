<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */
/* @var $model common\models\core\OrganizationSetting */

use common\models\core\Picture;
use borales\extensions\phoneInput\PhoneInput;
use Imagine\Image\ManipulatorInterface;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', 'Organization Settings')];
\yii\web\YiiAsset::register($this);
$this->registerJsFile('@web/libs/bootstrap-tagsinput/bootstrap-tagsinput.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/pageScripts/organizationSettingsDetails.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/libs/bootstrap-tagsinput/bootstrap-tagsinput.css');

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
            $form = ActiveForm::begin([
                "options" => ["enctype" => "multipart/form-data"]
            ]);
            ?>
            <div class="card mb-4">
                <div class="card-header">
                    <span class="float-right mt-1">
                        <?= Html::submitButton(Yii::t('core_system','Save'), ['id' => 'submitButton', 'class' => 'btn btn-block btn-warning']); ?>
                    </span>
                    <h4><?=Yii::t('core_organization', 'Info')?></h4>
                </div>
                <div class="card-body borderTop">
                    <div class="row mb-3">
                        <div class="col-md-3 mt-2">
                            <label for="public_name"><?=Yii::t('core_organization', 'Public Name')?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="public_name" class="form-control" maxlength="64" value="<?=Yii::$app->user->identity->selectedOrganization->name?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 mt-2">
                            <label for="public_name"><?=Yii::t('core_organization', 'Legal Name')?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="legal_name" class="form-control" maxlength="64" value="<?=Yii::$app->user->identity->selectedOrganization->legal_name?>" <?=(Yii::$app->user->identity->selectedOrganization->kyc === 'approved' ? 'readonly' : '')?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 mt-2">
                            <label for="sms_name"><?=Yii::t('core_organization', 'Sms Name')?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="sms_name" class="form-control" maxlength="11" value="<?=($valueDecoded->sms_name ?? '')?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 mt-2">
                            <label for="contact_email"><?=Yii::t('core_organization', 'Contact Email')?></label>
                        </div>
                        <div class="col-md-9">
                                <input type="text" id="contact_email" class="form-control" name="contact_email" value="<?php
                                if (is_array($valueDecoded->contact_email)) {
                                    foreach ($valueDecoded->contact_email as $ce) {
                                        echo $ce . ',';
                                    }
                                } else {
                                    echo $valueDecoded->contact_email;
                                }
                                ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mt-2">
                            <label for="contact_phone"><?=Yii::t('core_organization', 'Contact Phone')?></label>
                        </div>
                        <div class="col-md-9">
                            <?= $form->field($model, 'contact_phone')->label(false)->widget(PhoneInput::className(), [
                                'options'   =>  [
                                    'id' => 'contact_phone',
                                    'value' => ($valueDecoded->contact_phone ?? ''),
                                ],
                                'jsOptions' => [
                                    'preferredCountries' => Yii::$app->params['inputSettings']['phoneInput']['preferredCountries'],
                                    'onlyCountries'     =>  Yii::$app->params['inputSettings']['phoneInput']['onlyCountries']
                                ]
                            ]) ?>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-3 mt-2">
                            <label for="website"><?=Yii::t('core_organization', 'Website')?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="website" class="form-control" value="<?=($valueDecoded->website ?? '')?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 mt-1">
                            <label for="organization_logo"><?=Yii::t('core_organization', 'Organization Logo')?></label><br><small class="text-muted"><?=Yii::t('core_system', 'Recommended square dimensions')?></small>
                        </div>
                        <div class="col-md-9">
                            <a type="button" id="buttonFile" class="btn btn-outline-dark">+ <?=Yii::t('core_system', 'Select image')?></a>
                            <span class="ml-3 imageSelected"></span>
                            <?=$form->field($model, 'file')->fileInput(['multiple' => false, 'style' => 'display:none', 'id' => 'organization_logo'])->label(false)?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 mt-5 text-right" id="buttons">
                            <?php
                            if (isset($valueDecoded->organization_logo)) {
                                echo Html::a(Yii::t('core_system', 'Delete logo'), ['delete-logo', 'id' => $model->organization_id, 'setting' => $model->setting, 'logo' => $valueDecoded->organization_logo], [
                                    'class' => 'btn btn-outline-danger btn-sm',
                                    'id' => 'deleteLogo',
                                    'data' => [
                                        'confirm' => Yii::t('core_system', 'Are you sure you want to delete this logo?'),
                                        'method' => 'post',
                                    ],
                                ]);
                            }
                            ?>
                            <a id="deleteImageUploadedBtn" class="btn btn-outline-danger btn-sm mt-2" style="display: none"><?=Yii::t('core_clipcard', 'Delete Uploaded Image')?></a>
                        </div>
                        <div class="col-mb-4">
                            <div class="logoPreviewUpload">
                                <img width="150" height="150" id="logo_preview_upload">
                            </div>
                            <?php
                            if (isset($valueDecoded->organization_logo)) {
                                $logoDatabase = Picture::findOne(['id' => $valueDecoded->organization_logo]);
                                if (isset($logoDatabase)) {
                                    ?>
                                    <div class="logoPreviewDataBase">
                                        <img src="<?=Yii::$app->thumbnailer->get($logoDatabase->uri, 100, 100, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true)?>" width="150" height="150" id="logo_preview_database">
                                    </div>
                                <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <span class="float-right mt-1">
                        <?= Html::submitButton(Yii::t('core_system','Save'), ['id' => 'submitButton', 'class' => 'btn btn-block btn-warning']); ?>
                    </span>
                    <h4><?=Yii::t('core_organization', 'Organization Address')?></h4>
                </div>
                <div class="card-body borderTop">
                    <div class="row mb-3">
                        <div class="col-md-3 mt-2">
                            <label for="billing_address"><?=Yii::t('core_organization', 'Billing Address')?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="billing_address" class="form-control" maxlength="128" value="<?=($valueDecoded->billing_address ?? '')?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 mt-2">
                            <label for="visiting_address"><?=Yii::t('core_organization', 'Visiting Address')?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="visiting_address" class="form-control" maxlength="128" value="<?=($valueDecoded->visiting_address ?? '')?>">
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
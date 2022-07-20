<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\core\ApiKey */

$this->title = Yii::t('core_system', 'Update') . ': ' . Yii::t('api_key', ucfirst($model->key_type));
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_system', 'Api Keys'), 'url' => ['index-organization']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('api_key', ucfirst($model->key_type)), 'url' => ['view-organization', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('core_system', 'Update');

$this->registerJsFile('@web/libs/bootstrap-tagsinput/bootstrap-tagsinput.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/pageScripts/apiKeyUpdate.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/libs/bootstrap-tagsinput/bootstrap-tagsinput.css');

if ($model->key_config !== null) {
    $keyConfigDecoded = json_decode($model->key_config);
}
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_system', 'Update')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=Yii::t('api_key', ucfirst($model->key_type))?></h4>
        </div>
        <div class="card-body borderTop">
            <?php $form = ActiveForm::begin() ?>
            <div class="col-12 mb-5">
                <div class="row">
                    <div class="col-md-2 mt-2">
                        <?=Yii::t('core_system', 'Key Name')?>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="apiName" id="apiName" class="form-control" value="<?=(isset($model->key_config, $keyConfigDecoded->name) ? $keyConfigDecoded->name : '')?>">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-check mt-3 mb-5"><input class="form-check-input expiryDateCheckbox" id="expiryDateCheckbox" type="checkbox" <?=(isset($model->expiry_date) ? 'checked' : '')?> onclick="showExpiryDate()">
                            <div class="form-check-label">
                                <?=Yii::t('core_system', 'Expiry Date')?>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div id="expiry_date">
                            <?=$form->field($model, 'expiry_date')->widget(DatePicker::className(), ['options' => ['class' => 'form-control', 'value' => $model->expiry_date], 'dateFormat' => 'yyyy-MM-dd'])->label(false)?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-check mt-3 mb-5"><input class="form-check-input allowIPsCheckbox" id="allowIPsCheckbox" type="checkbox" <?=(isset($model->key_config, $keyConfigDecoded->allow_ip) && !empty($keyConfigDecoded->allow_ip) ? 'checked' : '')?> onclick="showAllowIPs()">
                            <div class="form-check-label">
                                <?=Yii::t('core_system', 'Allow IP´s')?>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div id="allow_ip">
                            <?php
                            if ($model->key_config === null) {
                                echo '<input type="text" id="allow_ip_input" class="form-control" name="allow_ip_input">';
                            } else {
                                ?>
                                <input type="text" id="allow_ip_input" class="form-control" name="allow_ip_input" value="<?php
                                if (is_array($keyConfigDecoded->allow_ip)) {
                                    foreach ($keyConfigDecoded->allow_ip as $ap) {
                                        echo $ap . ',';
                                    }
                                } else {
                                    echo $keyConfigDecoded->allow_ip;
                                }
                                ?>">
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?=$form->field($model, 'key_config')->textarea(['style' => 'display: none'])->label(false)?>
                </div>
            </div>
            <?= Html::submitButton(Yii::t('core_system', 'Update'), ['class' => 'btn btn-warning']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
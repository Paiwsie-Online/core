<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\Organization */

$this->title = Yii::t('core_organization', 'Register Organization');
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin();
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_organization', 'Register Organization')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=Yii::t('core_organization', 'New Organization')?></h4>
        </div>
        <div class="card-body borderTop">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true]) ?>
                    <?= Html::submitButton(Yii::t('core_system', 'Register'), ['class' => 'btn btn-warning']) ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
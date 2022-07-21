<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Association */

$this->title = Yii::t('core_organization', 'Register association');
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin();
?>

    <div class="col-12 mb-4">
        <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
        <h2><?=Yii::t('core_organization', 'Register association')?></h2>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><?=Yii::t('core_organization', 'New association')?></h4>
            </div>
            <div class="card-body borderTop">
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'tax_number', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true]) ?>
                        <input type="text" name="street" class="form-control" placeholder="street address">
                        <input type="text" name="zip" class="form-control" placeholder="zip">
                        <input type="text" name="city" class="form-control" placeholder="city">

                        <?= Html::submitButton(Yii::t('core_system', 'Register'), ['class' => 'btn btn-warning']) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\SystemContent */

$this->title = Yii::t('core_system', 'Update System Content: {name}', [
    'name' => $model->content,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_system', 'System Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->content, 'url' => ['view', 'instance' => $model->instance ,'content' => $model->content]];
$this->params['breadcrumbs'][] = Yii::t('core_system', 'Update');
?>

<?php $form = ActiveForm::begin() ?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_system', 'Update')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=$model->content?></h4>
        </div>
        <div class="card-body borderTop">
            <div class="col-md-6">
                <?= $form->field($model, 'value')->textarea() ?>
                <?= Html::submitButton(Yii::t('core_system', 'Update'), ['class' => 'btn btn-warning']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


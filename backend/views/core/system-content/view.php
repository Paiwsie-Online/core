<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\SystemContent */

$this->title = $model->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_system', 'System Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_system', 'System Content')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <span class="float-right mt-2">
                <?= Html::a(Yii::t('core_system', 'Update'), ['update', 'instance' => $model->instance, 'content' => $model->content], ['class' => 'btn btn-warning']) ?>
            </span>
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body indexView">
            <table class="table table-striped" style="width: 100%">
                <tr>
                    <td class="poppinsStrong"><?=Yii::t('core_system', 'Content')?></td>
                    <td><?=$model->content?></td>
                </tr>
                <tr>
                    <td class="poppinsStrong"><?=Yii::t('core_clipcard', 'Value')?></td>
                    <td><?=$model->value?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\ApiKey;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\core\ApiKeySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core_system', 'Api Keys');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <span class="float-right mt-2">
                <?= Html::a('+ ' . Yii::t('core_system', 'Create Api Key'), ['create-organization'], ['class' => 'btn btn-warning']) ?>
            </span>
            <h4><?=Yii::t('core_system', 'Your Api Keys')?></h4>
        </div>
        <div class="card-body indexView">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => ApiKey::getIndexOrganizationNoSettings(),
                'emptyText' => ' <i class="fas fa-info-circle fs-5"></i>' . ' ' . Yii::t('core_system', 'No result found'),
            ]); ?>
        </div>
    </div>
</div>
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\core\SystemContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core_system', 'System Content');
$this->params['breadcrumbs'][] = $this->title;

$instances = User::getInstances();
$instances['default'] = 'default';
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Html::encode($this->title)?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=Yii::t('core_system', 'Content')?></h4>
        </div>
        <div class="card-body indexView">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' =>  'instance',
                        'filter'    =>  $instances,
                        'visible'   =>  (Yii::$app->user->identity->hasAccess('systemAdmin', 'read'))
                    ],
                    [
                        'attribute' =>  'content',
                        'label'    =>  Yii::t('core_system', 'Content'),
                    ],
                    [
                        'attribute' =>  'value',
                        'label'    =>  Yii::t('core_clipcard', 'Value'),
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'visibleButtons' => [
                            'view'  =>  true,
                            'update'    =>  false,
                            'delete'    =>  false
                        ]
                    ],
                ],
                'emptyText' => ' <i class="fas fa-info-circle fs-5"></i>' . ' ' . Yii::t('core_system', 'No result found'),
            ]) ?>
        </div>
    </div>
</div>
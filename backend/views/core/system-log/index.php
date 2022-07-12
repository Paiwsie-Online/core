<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\User;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\core\SystemLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core_system','User Logs');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=$this->title?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=Yii::t('core_system','All User Logs')?></h4>
        </div>
        <div class="card-body indexView">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'user_id',
                    'user_name',
                    [
                        'attribute' =>  'organization_name',
                        'value' =>  function($data) {
                            if ($data->organization_name !== null) {
                                return $data->organization_name;
                            } else {
                                return Yii::t('core_system','Not Set');
                            }
                        }
                    ],
                    'message_short',
                    'message',
                    [
                        'attribute' =>  'log_time',
                        'value' =>  function($data) {
                            return ($data->log_time ? Yii::$app->formatter->asDatetime($data->log_time, 'php:Y-m-d H:i') : Yii::t('core_system', 'Not Set'));
                        }
                    ],
                    [
                        'attribute' =>  'instance',
                        'filter'    =>  User::getInstances(),
                        'visible'   =>  (Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'visibleButtons' => [
                            'view'  => true,
                            'update'    =>  false,
                            'delete'    =>  false
                        ]
                    ],
                ],
                'emptyText' => ' <i class="fas fa-info-circle fs-5"></i>' . ' ' . Yii::t('core_system', 'No result found'),
            ]); ?>
        </div>
    </div>
</div>
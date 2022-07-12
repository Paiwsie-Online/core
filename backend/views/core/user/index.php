<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\core\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core_organization', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=Yii::t('core_user', 'User List')?></h4>
        </div>
        <div class="card-body indexView">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'full_name',
                    [
                        'attribute' =>  'country',
                        'filter'    =>  User::getCountry(),
                        'value' =>  function($data) {
                            if ($data->country !== null) {
                                return $data->country;
                            } else {
                                return Yii::t('core_system', 'Not Set');
                            }
                        }
                    ],
                    [
                        'attribute' =>  'pnr',
                        'value' =>  function($data) {
                            if ($data->pnr !== null) {
                                return $data->pnr;
                            } else {
                                return Yii::t('core_system', 'Not Set');
                            }
                        }
                    ],
                    'email:email',
                    [
                        'attribute' =>  'email_status',
                        'filter'    =>  User::emailStatus(),
                        'value' => function($data) {
                            return Yii::t('user', ucfirst($data->email_status));
                        }
                    ],
                    [
                        'attribute' =>  'status',
                        'filter'    =>  User::userStatus(),
                        'value' => function($data) {
                            return Yii::t('user', ucfirst($data->status));
                        }
                    ],
                    [
                        'attribute' =>  'registered',
                        'filter' => '<div class="row" style="width: 330px">
                            <div class="col-md-5">' . DatePicker::widget([
                                'name'  => 'UserSearch[registeredStart]',
                                'value'  => ($_GET['UserSearch']['registeredStart'] ?? ''),
                                'dateFormat' => 'php:Y-m-d',
                                'options' => [
                                    'class' => 'form-control'
                                ]
                            ]) . '</div>
                            <div class="col-md-1 mt-2 mr-3">
                                <i class="fas fa-horizontal-rule"></i>
                            </div>
                            <div class="col-md-5">' . DatePicker::widget([
                                'name'  => 'UserSearch[registeredEnd]',
                                'value'  => ($_GET['UserSearch']['registeredEnd'] ?? ''),
                                'dateFormat' => 'php:Y-m-d',
                                'options' => [
                                    'class' => 'form-control'
                                ]
                            ]) . '</div>
                            </div>',
                        'value' =>  function($data) {
                            return Yii::$app->formatter->asDatetime($data->registered, 'php:Y-m-d H:i');
                        }
                    ],
                    [
                        'attribute' =>  'instance',
                        'filter'    =>  User::getInstances(),
                        'visible'   =>  (Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
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
            ]); ?>
        </div>
    </div>
</div>
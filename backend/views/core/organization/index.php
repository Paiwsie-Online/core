<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\Organization;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\core\OrganizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core_organization', 'Organizations');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=Yii::t('core_organization', 'All organizations')?></h4>
        </div>
        <div class="card-body indexView">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    //'id',
                    [
                        'attribute' =>  'name',
                        'label'    =>  Yii::t('core_system', 'Name'),
                    ],
                    [
                        'attribute' =>  'tax_number',
                        'value' =>  function($data) {
                            if ($data->tax_number !== null) {
                                return $data->tax_number;
                            } else {
                                return Yii::t('core_system', 'Not Set');
                            }
                        }
                    ],
                    'created_by_full_name',
                    [
                        'attribute' =>  'created_at',
                        'filter' => '<div class="row" style="width: 330px">
                            <div class="col-md-5">' . DatePicker::widget([
                                'name'  => 'OrganizationSearch[createdStart]',
                                'value'  => ($_GET['OrganizationSearch']['createdStart'] ?? ''),
                                'dateFormat' => 'php:Y-m-d',
                                'options' => [
                                    'class' => 'form-control'
                                ]
                            ]) . '</div>
                            <div class="col-md-1 mt-2 mr-3">
                                <i class="fas fa-horizontal-rule"></i>
                            </div>
                            <div class="col-md-5">' . DatePicker::widget([
                                'name'  => 'OrganizationSearch[createdEnd]',
                                'value'  => ($_GET['OrganizationSearch']['createdEnd'] ?? ''),
                                'dateFormat' => 'php:Y-m-d',
                                'options' => [
                                    'class' => 'form-control'
                                ]
                            ]) . '</div>
                            </div>',
                        'value' =>  function($data) {
                            return ($data->created_at ? Yii::$app->formatter->asDatetime($data->created_at, 'php:Y-m-d H:i') : Yii::t('core_system', 'Not Set'));
                        }
                    ],
                    [
                        'attribute' =>  'instance',
                        'filter'    =>  Organization::getInstances(),
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
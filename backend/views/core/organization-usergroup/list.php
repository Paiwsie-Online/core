<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\core\OrganizationUsergroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core_organization', '{organization} user groups', ['organization' => Yii::$app->user->identity->selectedOrganization['name']]);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_organization', 'User groups')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <span class="float-right mt-2">
                <?= Html::a('+ ' . Yii::t('core_organization', 'Create user group'), ['newgroup'], ['class' => 'btn btn-warning']) ?>
            </span>
            <h4><?=Yii::t('core_organization', 'Groups')?></h4>
        </div>
        <div class="card-body indexView">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' =>  'name',
                        'label' => Yii::t('core_system', 'Name'),
                        'format' => 'raw',
                        'value' =>  function($data) {
                            return '<a href="/organization-usergroup/view?id=' . $data->id . '">' . $data->name . '</a>';
                        }
                    ],
                    'created_by_full_name',
                    [
                        'attribute' =>  'created',
                        'filter' => '<div class="row" style="width: 330px">
                            <div class="col-md-5">' . DatePicker::widget([
                                'name'  => 'OrganizationUsergroupSearch[createdStart]',
                                'value'  => ($_GET['OrganizationUsergroupSearch']['createdStart'] ?? ''),
                                'dateFormat' => 'php:Y-m-d',
                                'options' => [
                                    'class' => 'form-control'
                                ]
                            ]) . '</div>
                            <div class="col-md-1 mt-2 mr-3">
                                <i class="fas fa-horizontal-rule"></i>
                            </div>
                            <div class="col-md-5">' . DatePicker::widget([
                                'name'  => 'OrganizationUsergroupSearch[createdEnd]',
                                'value'  => ($_GET['OrganizationUsergroupSearch']['createdEnd'] ?? ''),
                                'dateFormat' => 'php:Y-m-d',
                                'options' => [
                                    'class' => 'form-control'
                                ]
                            ]) . '</div>
                            </div>',
                        'value' =>  function($data) {
                            return Yii::$app->formatter->asDatetime($data->created, 'php:Y-m-d H:i');
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'visibleButtons' => [
                            'view'  =>  true,
                            'update'    =>  false,
                            'delete'    =>  false
                        ],
                    ],
                ],
                'emptyText' => ' <i class="fas fa-info-circle fs-5"></i>' . ' ' . Yii::t('core_system', 'No result found'),
            ]); ?>
        </div>
    </div>
</div>
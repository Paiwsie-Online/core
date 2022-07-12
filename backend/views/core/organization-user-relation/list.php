<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\OrganizationUserRelation;
use common\models\core\OrganizationUserRelationInvitation;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\core\OrganizationUserRelationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core_organization', '{organization} users', ['organization' => Yii::$app->user->identity->selectedOrganization['name']]);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_organization', 'Users')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <span class="float-right mt-2">
                <?= Html::a('+ ' . Yii::t('core_organization', 'Invite user'), ['invite'], ['class' => 'btn btn-warning']) ?>
            </span>
            <h4><?=Yii::t('core_organization', 'Users of this organization')?></h4>
        </div>
        <div class="card-body indexView">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' =>  'user_full_name',
                        'format' => 'raw',
                        'value' =>  function($data) {
                            $invitation = OrganizationUserRelationInvitation::findOne(['our_id' => $data->id]);
                            return ($data->user_full_name ? '<a href="/organization-user-relation/view?id=' . $data->id . '">' . $data->user_full_name . '</a>' : (isset($invitation) ? '<small>' . Yii::t('core_system', 'Sent To') . ': </small>' . $invitation->sent_to : Yii::t('core_system', 'Not Set')));
                        }
                    ],
                    [
                        'attribute' =>  'title',
                        'value' =>  function($data) {
                            return Yii::t('organization_user_relation', $data->title);
                        }
                    ],
                    'added_by_full_name',
                    [
                        'attribute' =>  'user_level',
                        'label' => Yii::t('core_organization', 'User Level'),
                        'filter'    =>  OrganizationUserRelation::getUserLevelOptions(),
                        'value' => function($data) {
                            return Yii::t('organization_user_relation', ucfirst($data->user_level));
                        }
                    ],
                    [
                        'attribute' =>  'added',
                        'filter' => '<div class="row" style="width: 330px">
                            <div class="col-md-5">' . DatePicker::widget([
                                'name'  => 'OrganizationUserRelationSearch[addedStart]',
                                'value'  => ($_GET['OrganizationUserRelationSearch']['addedStart'] ?? ''),
                                'dateFormat' => 'php:Y-m-d',
                                'options' => [
                                    'class' => 'form-control'
                                ]
                            ]) . '</div>
                            <div class="col-md-1 mt-2 mr-3">
                                <i class="fas fa-horizontal-rule"></i>
                            </div>
                            <div class="col-md-5">' . DatePicker::widget([
                                'name'  => 'OrganizationUserRelationSearch[addedEnd]',
                                'value'  => ($_GET['OrganizationUserRelationSearch']['addedEnd'] ?? ''),
                                'dateFormat' => 'php:Y-m-d',
                                'options' => [
                                    'class' => 'form-control'
                                ]
                            ]) . '</div>
                            </div>',
                        'value' =>  function($data) {
                            return Yii::$app->formatter->asDatetime($data->added, 'php:Y-m-d H:i');
                        }
                    ],
                    [
                        'attribute' =>  'status',
                        'filter'    =>  OrganizationUserRelation::getStatusOptions(),
                        'value' => function($data) {
                            return Yii::t('organization_user_relation', ucfirst($data->status));
                        }
                    ],
                    [
                        'attribute' =>  'status_changed',
                        'value' =>  function($data) {
                            return ($data->status_changed ? Yii::$app->formatter->asDatetime($data->status_changed, 'php:Y-m-d H:i') : Yii::t('core_system', 'Not Set'));
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'visibleButtons' => [
                            'view'  => function($data){
                                return ($data->status === 'accepted');
                            },
                            'update'    =>  false,
                            'delete'    =>  function($data){
                                return ($data->status !== 'accepted');
                            }
                        ]
                    ],
                ],
                'emptyText' => ' <i class="fas fa-info-circle fs-5"></i>' . ' ' . Yii::t('core_system', 'No result found'),
            ]); ?>
        </div>
    </div>
</div>

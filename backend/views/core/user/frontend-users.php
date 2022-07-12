<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use borales\extensions\phoneInput\PhoneInput;
use common\models\core\User;
use common\models\core\UserSetting;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\core\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core_user', 'Registered Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .iti__arrow {
        display: none;
    }
    .iti--allow-dropdown .iti__flag-container:hover {
        cursor: default;
    }
    .iti--allow-dropdown .iti__flag-container:hover .iti__selected-flag {
        background-color: rgba(0, 0, 0, 0);
    }
</style>

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
                        'attribute' =>  '',
                        'label' => Yii::t('frontend', 'Birthdate'),
                        'filter'    =>  false,
                        'value' => function($data) {
                            $birthDate = UserSetting::findOne(['user_id' => $data->id, 'setting' => 'birthdate']);
                            if (isset($birthDate)) {
                                $valueDecoded = json_decode($birthDate->value);
                            }
                            return (isset($valueDecoded, $valueDecoded->birthdate) ? $valueDecoded->birthdate : Yii::t('core_system', 'Not Set'));
                        }
                    ],
                    [
                        'attribute' =>  'phone',
                        'format' => 'raw',
                        'value' => function($data) {
                            return PhoneInput::widget([
                                'name' => 'phone',
                                'options' => [
                                    'class' => 'phoneList',
                                    'readonly' => true,
                                    'style' => 'border: 0; pointer-events: none; background-color: #ffffff; width: 180px',
                                ],
                                'value' => $data->phone,
                                'jsOptions' => [
                                    'preferredCountries' => Yii::$app->params['inputSettings']['phoneInput']['preferredCountries'],
                                    'onlyCountries'     =>  Yii::$app->params['inputSettings']['phoneInput']['onlyCountries']
                                ]
                            ]);
                        }
                    ],
                    [
                        'attribute' =>  'phone_status',
                        'filter'    =>  User::emailStatus(),
                        'value' => function($data) {
                            return Yii::t('user', ucfirst($data->phone_status));
                        }
                    ],
                    [
                        'attribute' =>  'email',
                        'value' => function($data) {
                            return ($data->email ?? Yii::t('core_system', 'Not Set'));
                        }
                    ],
                    [
                        'attribute' =>  'email_status',
                        'filter'    =>  User::emailStatus(),
                        'value' => function($data) {
                            return (isset($data->email_status) ? Yii::t('user', ucfirst($data->email_status)) : Yii::t('core_system', 'Not Set'));
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
                ],
                'emptyText' => ' <i class="fas fa-info-circle fs-5"></i>' . ' ' . Yii::t('core_system', 'No result found'),
            ]); ?>
        </div>
    </div>
</div>
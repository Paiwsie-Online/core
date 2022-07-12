<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\Enumeration;
use common\models\core\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\core\EnumerationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core_system', 'Enumerations');
$this->params['breadcrumbs'][] = $this->title;

$instances = User::getInstances();
$instances['default'] = 'default';

$this->registerJsFile('@web/js/pageScripts/enumerationIndex.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <span class="float-right mt-2">
                <?php
                    if (Yii::$app->user->identity->hasAccess('siteAdmin', 'update') || Yii::$app->user->identity->hasAccess('systemAdmin', 'update')) {
                        echo Html::a('+ ' . Yii::t('core_system', 'Create Enumeration'), ['create'], ['class' => 'btn btn-warning']);
                    }
                ?>
            </span>
            <h4><?=Yii::t('core_system', 'Enumerations')?></h4>
        </div>
        <?php
        $temp_list = Enumeration::find()->indexBy('enumerator')->all();
        $enumerators = ArrayHelper::map($temp_list, 'enumerator', 'enumerator');
        ?>
        <div class="card-body indexView">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'label' => Yii::t('core_system', 'Id'),

                    ],
                    [
                        'attribute' =>  'enumerator',
                        'filter'    =>  $enumerators,
                        'visible'   =>  (Yii::$app->user->identity->hasAccess('systemAdmin', 'read'))
                    ],
                    [
                        'attribute' =>  'parentvalue',
                        'value'   =>  function($data) {
                            return ($data->parentvalue ?? Yii::t('core_system', 'Not Set'));
                        }
                    ],
                    [
                        'attribute' =>  'value',
                        'label'    =>  Yii::t('core_clipcard', 'Value'),
                    ],
                    [
                        'attribute' => '',
                        'filter' => false,
                        'format' => 'raw',
                        'value' => function($data) {
                            if ($data->enumerator !== 'timezone') {
                                return (Yii::$app->user->identity->hasAccess('systemAdmin', 'update') ? '<button class="btn btn-warning btn-sm buttonTransparent editOrganizationStyle" value="' . $data->id . '"><i class="fas fa-pen text-warning"></i></button>' : '') . (Yii::$app->user->identity->hasAccess('systemAdmin', 'delete') ? Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['delete', 'id' => $data->id], [
                                            'class' => 'btn btn-outline-danger btn-sm buttonTransparent ml-2',
                                            'data' => [
                                                'confirm' => Yii::t('core_system', 'Are you sure you want to delete this enumeration?'),
                                                'method' => 'post',
                                            ],
                                        ]
                                    ) : '');
                            } else {
                                return '';
                            }
                        },
                        'contentOptions' => ['class' => 'text-right'],
                    ],
                ],
                'emptyText' => ' <i class="fas fa-info-circle fs-5"></i>' . ' ' . Yii::t('core_system', 'No result found'),
            ]) ?>
        </div>
    </div>
</div>
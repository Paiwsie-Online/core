<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\Module;
use common\models\core\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\ApiKey */

if (isset($model->key_config)) {
    $keyConfigDecoded = json_decode($model->key_config);
}

$this->title = ($keyConfigDecoded->name ?? Yii::t('api_key', ucfirst($model->key_type)));
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_system', 'Api Keys'), 'url' => ['index-site-admin']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$checkOrganization = strpos($_SERVER['REQUEST_URI'], 'site-admin');
if ($checkOrganization !== false) {
    $site = 'siteAdmin';
}
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <span class="float-right mt-2">
                <?= Html::a(Yii::t('core_system', 'Update'), ['update-site-admin', 'id' => $model->id], ['class' => 'btn btn-warning mr-3']) ?>
                <?= Html::a(Yii::t('core_system', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data' => [
                        'confirm' => Yii::t('core_system', 'Are you sure you want to delete this api key?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </span>
            <h4><?=Yii::t('core_system', 'Key Access')?> - <?=($model->type === 'test' ? '<small class="badge badge-pill badge-warning mr-2">' . Yii::t('core_system', 'Test') . '</small>' : '<small class="badge badge-pill badge-warning mr-2">' . Yii::t('core_system', 'Live') . '</small>')?> <small class="poppinsStrong text-muted"><?=Yii::t('core_system', 'Created By')?> <?= (isset($model->created_by) ? User::getUserName($model->created_by) : Yii::t('core_system', 'Not Set')) ?> <?= $model->created_at ?></small></h4>
        </div>
        <div class="card-body indexView">
            <div class="row">
                <div class="col-12">
                    <?php
                    if (isset($model->expiry_date)) {
                        echo '<p class="mr-4 float-right">' . Yii::t('core_system', 'Expiry Date') . ': ' . $model->expiry_date . '</p>';
                    }
                    ?>
                    <p class="ml-4">
                        <?=$model->key?>
                    </p>
                </div>
                <?php
                if (isset($model->key_config, $keyConfigDecoded->allow_ip) && !empty($keyConfigDecoded->allow_ip)) {
                    echo '<div class="col-md-9">';
                } else {
                    echo '<div class="col-12">';
                }
                ?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center"><?=Yii::t('core_system', 'Create')?></th>
                            <th class="text-center"><?=Yii::t('core_system', 'Read')?></th>
                            <th class="text-center"><?=Yii::t('core_system', 'Update')?></th>
                            <th class="text-center"><?=Yii::t('core_system', 'Delete')?></th>
                        </tr>
                        </thead>
                        <?php
                        foreach ($model->siteadminApiKeys as $module) {
                            $moduleName = Module::findOne(['id' => $module->module_id]);
                            ?>
                            <tr>
                                <td class="poppinsStrong"><?= $moduleName->name ?></td>
                                <?php
                                $rightArray = ['create', 'read', 'update', 'delete'];
                                foreach ($rightArray as $ra) {
                                    $right = 'right_' . $ra;
                                    if ($module->module_id !== 'siteAdmin' && $module->module_id !== 'systemAdmin') {
                                        ?>
                                        <td class="text-center"><a class="dropdown-toggle hide-arrow" href="#" data-toggle="dropdown" aria-expanded="false">
                                        <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                            <span class="px-1 mr-lg-2 ml-2 ml-lg-0"><?= ($module->$right === 1 ? '<i class="fas fa-check-square fa-2x"></i>' : '<i class="fas fa-times-square fa-2x"></i>') ?></span>
                                            </span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <?= Html::a('<i class="fas fa-check-square fa-2x"></i> ' . Yii::t('core_system', 'Has access'), ['update-rights', 'id' => $model->id, 'module_id' => $module->module_id, 'right' => $ra, 'value' => 1, 'site' => $site], [
                                                    'class' => 'dropdown-item',
                                                    'data' => [
                                                        'method' => 'post',
                                                    ],
                                                ]);?>
                                                <?= Html::a('<i class="fas fa-times-square fa-2x"></i> ' . Yii::t('core_system', 'No access'), ['update-rights', 'id' => $model->id, 'module_id' => $module->module_id, 'right' => $ra, 'value' => 0, 'site' => $site], [
                                                    'class' => 'dropdown-item',
                                                    'data' => [
                                                        'method' => 'post',
                                                    ],
                                                ]);
                                                ?>
                                            </div>
                                        </td>
                                    <?php
                                    } else {
                                        echo '<td class="text-center"><span class="px-1 mr-lg-2 ml-2 ml-lg-0"><i class="fas fa-check-square fa-2x text-secondary"></i></span></td>';
                                    }
                                }
                                ?>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <?php
                if (isset($model->key_config, $keyConfigDecoded->allow_ip) && !empty($keyConfigDecoded->allow_ip)) {
                    ?>
                    <div class="col-md-3">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th class="text-center"><?=Yii::t('core_system', 'Allowed IP´s')?></th>
                                </tr>
                            </thead>
                            <?php
                            foreach ($keyConfigDecoded->allow_ip as $allow_ip) {
                                ?>
                                <tr>
                                    <td><?=$allow_ip?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
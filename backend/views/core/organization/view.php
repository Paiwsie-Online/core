<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\OrganizationGroupModuleRight;
use common\models\core\Module;
use common\models\core\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\Organization */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization','Organizations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerJsFile('@web/js/pageScripts/organizationView.js',['depends' => [\yii\web\YiiAsset::className()]]);

?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_organization', 'Organization')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=$this->title?></h4>
        </div>
        <div class="card-body borderTop">
            <div class="row">
                <div class="col-md-5">
                    <div class="card border-info mb-4">
                        <div class="card-body cardContent">
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_organization', 'Tax Number')?></span>: <?= ($model->tax_number ?? Yii::t('core_system','Not Set')) ?>
                            </div>
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_system', 'Created By')?></span>: <?= (User::getUserName($model->created_by) ?? Yii::t('core_system','Not Set')) ?>
                            </div>
                            <div class="mb-5">
                                <span class="poppinsStrong"><?=Yii::t('core_system', 'Instance')?></span>: <?= ($model->instance ?? Yii::t('core_system','Not Set')) ?>
                            </div>
                            <div>
                                <span class="poppinsStrong"><?=Yii::t('core_system', 'Created Time')?></span>: <?=(Yii::$app->formatter->asDatetime($model->created, 'php:Y-m-d H:i') ?? Yii::t('core_system','Not Set'))?>
                            </div>
                        </div>
                    </div>
                    <div class="card border-info mb-4">
                        <div class="card-header cardHeader">
                            <h5><?=Yii::t('core_system', 'Modules')?></h5>
                        </div>
                        <div class="card-body borderTop cardContent">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><?=Yii::t('core_system', 'Active Modules')?></h6>
                                    <div class="row">
                                        <?php
                                        $organizationModules = $model->organizationModuleRelations;
                                        $activeOrganizationModules = [];
                                        foreach ($organizationModules as $cModule) {
                                            $module = Module::findOne(['id' => $cModule->module_id]);
                                            $activeOrganizationModules [$module->id] = $module->name;
                                            ?>
                                            <div class="col-md-9 mb-2">
                                                <?=Yii::t('module', $module->name)?>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <?php
                                                if (Yii::$app->user->identity->hasAccess('systemAdmin', 'update')) {
                                                    if ($cModule->module_id !== 'systemAdmin') {
                                                        ?>
                                                        <span class="float-right">
                                                            <?= Html::a('<i class="fas fa-trash-alt"></i>', ['delete-organization-modules', 'organization_id' => $model->id, 'module_id' => $cModule->module_id], [
                                                                'class' => 'btn btn-sm btn-outline-danger',
                                                                'data' => [
                                                                    'confirm' => Yii::t('core_system', 'Are you sure you want to delete this module?'),
                                                                    'method' => 'post',
                                                                ],
                                                            ]) ?>
                                                        </span>
                                                    <?php
                                                    }
                                                } elseif (Yii::$app->user->identity->hasAccess('siteAdmin', 'update')) {
                                                    if ($cModule->module_id !== 'siteAdmin' && $cModule->module_id !== 'systemAdmin') {
                                                        ?>
                                                        <span class="float-right">
                                                            <?= Html::a('<i class="fas fa-trash-alt"></i>', ['delete-organization-modules', 'organization_id' => $model->id, 'module_id' => $cModule->module_id], [
                                                                'class' => 'btn btn-sm btn-outline-danger',
                                                                'data' => [
                                                                    'confirm' => Yii::t('core_system', 'Are you sure you want to delete this module?'),
                                                                    'method' => 'post',
                                                                ],
                                                            ]) ?>
                                                        </span>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6><?=Yii::t('core_system', 'All Modules')?></h6>
                                    <div class="row">
                                        <?php
                                        $availableModules = Yii::$app->params['modules']['available'];
                                        foreach ($availableModules as $am) {
                                            $moduleName = Module::findOne(['id' => $am]);
                                            if (!isset($activeOrganizationModules[$moduleName->id])) {
                                                ?>
                                                <div class="col-md-9 mb-2">
                                                    <?=Yii::t('module', $moduleName->name)?>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <?php
                                                    if (Yii::$app->user->identity->hasAccess('systemAdmin', 'update')) {
                                                        ?>
                                                        <span class="float-right">
                                                            <?=Html::a('<i class="fas fa-plus"></i>', ['add-organization-modules', 'organization_id' => $model->id, 'module_id' => $moduleName->id], ['class' => 'btn btn-sm btn-warning',])?>
                                                        </span>
                                                        <?php
                                                    } elseif (Yii::$app->user->identity->hasAccess('siteAdmin', 'update')) {
                                                        if ($moduleName->id !== 'siteAdmin') {
                                                            ?>
                                                            <span class="float-right">
                                                                <?=Html::a('<i class="fas fa-plus"></i>', ['add-organization-modules', 'organization_id' => $model->id, 'module_id' => $moduleName->id], ['class' => 'btn btn-sm btn-warning',])?>
                                                            </span>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            <?php
                                            }
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <?php
                    $organizationGroups = $model->organizationUsergroups;
                    if (!empty($organizationGroups)) {
                        ?>
                        <div class="card border-info">
                            <div class="card-header cardHeader">
                                <h5><?=Yii::t('core_organization', 'Organization Groups')?></h5>
                            </div>
                            <div class="card-body borderTop cardContent">
                                <?php
                                foreach ($organizationGroups as $organizationGroup) {
                                    ?>
                                    <div class="card mb-4 border-info2">
                                        <div class="card-header cardHeader">
                                            <h6><?=$organizationGroup->name?></h6>
                                        </div>
                                        <div class="card-body borderTop cardContent indexView">
                                            <?php
                                            $groupModule = OrganizationGroupModuleRight::find()->where(['group_id' => $organizationGroup->id])->all();
                                            if (!empty($groupModule)) {
                                                ?>
                                                <table class="table table-striped" style="width: 100%">
                                                    <thead>
                                                    <tr class="text-center">
                                                        <th class="text-left"><?=Yii::t('core_system', 'Modules')?></th>
                                                        <th><?=Yii::t('core_system', 'Create')?></th>
                                                        <th><?=Yii::t('core_system', 'Read')?></th>
                                                        <th><?=Yii::t('core_system', 'Update')?></th>
                                                        <th><?=Yii::t('core_system', 'Delete')?></th>
                                                    </tr>
                                                    </thead>
                                                    <?php
                                                    foreach ($organizationModules as $cModule) {
                                                        $groupModules = OrganizationGroupModuleRight::find()->where(['cmr_id' => $cModule->id, 'group_id' => $organizationGroup->id])->all();
                                                        foreach ($groupModules as $gModule) {
                                                            $module = Module::findOne(['id' => $cModule->module_id]);
                                                            $rightArray = ['right_create', 'right_read', 'right_update', 'right_delete'];
                                                            ?>
                                                            <tr>
                                                                <td><?=Yii::t('module', $module->name)?></td>
                                                                <?php
                                                                foreach ($rightArray as $ra) {
                                                                    ?>
                                                                    <td class="text-center" id="<?=$ra?>">
                                                                        <?php
                                                                        if ($gModule->$ra === 1) {
                                                                            echo '<i class="fas fa-check-square fa-2x"></i>';
                                                                        } else {
                                                                            echo '<i class="fas fa-times-square fa-2x"></i>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </table>
                                            <?php
                                            } else {
                                            ?>
                                                <?=Yii::t('core_system', 'This Group do not have any module right yet!')?>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    } else {
                        ?>
                        <div class="card border-info">
                            <div class="card-header cardHeader">
                                <h6><?=Yii::t('core_system', 'This Organization do not have any group yet!')?></h6>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
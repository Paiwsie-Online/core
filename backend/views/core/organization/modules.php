<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\OrganizationModuleRelation;
use common\models\core\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\Organization */

$this->title = $model->name;
$this->params['breadcrumbs'][] = Yii::t('core_system', 'Modules');


$checkOrganizationSystemAdmin = OrganizationModuleRelation::findOne(['organization_id' => Yii::$app->user->identity->selectedOrganization->id, 'module_id' => 'systemAdmin']);
if (isset($checkOrganizationSystemAdmin)) {
    $modules = Yii::$app->params['modules']['all'];
} else {
    $checkOrganizationSiteAdmin = OrganizationModuleRelation::findOne(['organization_id' => Yii::$app->user->identity->selectedOrganization->id, 'module_id' => 'siteAdmin']);
    if (isset($checkOrganizationSiteAdmin)) {
        $modules = Yii::$app->params['modules']['available'];
    } else {
        $modules = Yii::$app->params['modules']['public'];
    }
}

$organizationModule = OrganizationModuleRelation::find()->where(['organization_id' => Yii::$app->user->identity->selectedOrganization->id])->all();

$countAll = count($modules);
if (isset($organizationModule)) {
    $countCM = count($organizationModule);
    $countDiff = $countAll-$countCM;
}
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2 class="mb-2 mt-1"><?=Yii::t('core_system', 'Modules')?></h2>
</div>
<div class="col-12 mb-3">
    <div class="card mb-3">
        <div class="card-header">
            <h4>
                <?=Yii::t('core_system', 'Active Modules')?>
                <?php
                if (!empty($organizationModule)) {
                    echo '<small class="text-muted">' . $countCM . Yii::t('core_system', 'u') . '</small>';
                }
                ?>
            </h4>
        </div>
        <div class="card-body borderTop">
            <div class="row">
                <?php
                $publicModules = Yii::$app->params['modules']['public'];
                $activeOrganizationModules = [];
                foreach ($model->organizationModuleRelations as $cModule) {
                    $module = Module::findOne(['id' => $cModule->module_id]);
                    $activeOrganizationModules[$module->id] = $module->name;
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card border-info">
                            <div class="card-header cardHeader">
                                <h5><?=Yii::t('module', $module->name)?></h5>
                            </div>
                            <div class="card-body cardContent borderTop">
                                <?=Yii::t('module', $module->description)?>
                            </div>
                            <div class="card-footer cardContent">
                                <?php
                                $publicModulesArray = [];
                                foreach ($publicModules as $publicModule) {
                                    $publicModulesArray[$publicModule] = $publicModule;
                                }
                                if (isset($publicModulesArray[$module->id]) && $module->id == $publicModulesArray[$module->id]) {
                                    if (is_array($module->dependants()) && count($module->dependants()) !== 0){
                                    ?>
                                        <button type="button" title="<?=Yii::t('core_system', '{modules} depends on this module, in order to remove it,  depending modules needs to be removed first', ['modules' => implode(', ', $module->dependants())])?>" class="btn btn-outline-secondary disabled mb-2"><?=Yii::t('core_system', 'Remove')?></button>
                                    <?php
                                    } else {
                                        echo Html::a(Yii::t('core_system', 'Remove'), ['delete-organization-modules', 'organization_id' => $model->id, 'module_id' => $cModule->module_id], ['class' => 'btn btn-outline-danger mb-2']);
                                    }
                                } else {
                                ?>
                                    <button type="button" title="<?=Yii::t('core_system', 'This module can not be removed')?>" class="btn btn-outline-secondary disabled mb-2"><?=Yii::t('core_system', 'Remove')?></button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card mb-3">
        <div class="card-header">
            <h4>
                <?=Yii::t('core_system', 'Inactive Modules')?>
                <?php
                if (!empty($organizationModule)) {
                    echo '<small class="text-muted">' . $countDiff . Yii::t('core_system', 'u') . '</small>';
                }
                ?>
            </h4>
        </div>
        <div class="card-body borderTop">
            <div class="row">
                <?php
                foreach ($publicModules as $publicModule) {
                    $module = Module::findOne(['id' => $publicModule]);
                    if (!isset($activeOrganizationModules[$module->id])) {
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-none bg-transparent border-info cardContent">
                                <div class="card-header cardHeader">
                                    <h5><?=Yii::t('module', $module->name)?></h5>
                                </div>
                                <div class="card-body cardContent borderTop">
                                    <?=Yii::t('module', $module->description)?>
                                </div>
                                <div class="card-footer cardContent">
                                    <?php
                                    if (is_array($module->dependencies()) && count($module->dependencies()) !== 0){
                                    ?>
                                    <button type="button" title="<?=Yii::t('core_system', 'This module depends on: {modules}, install requiered modules first', ['modules' => implode(' & ', $module->dependencies())])?>" class="btn btn-secondary disabled mb-2">+ <?=Yii::t('core_system', 'Add this module')?></button>

                                    <?php
                                    } else {
                                    ?>
                                    <?=Html::a('+ ' . Yii::t('core_system', 'Add this module'), ['add-organization-modules', 'organization_id' => $model->id, 'module_id' => $module->id], ['class' => 'btn btn-warning mb-2'])?>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
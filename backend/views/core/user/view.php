<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\OrganizationUsergroupUserRelation;
use common\models\core\SystemLog;
use common\models\core\UserSetting;
use Imagine\Image\ManipulatorInterface;

/* @var $this yii\web\View */
/* @var $model common\models\core\User */

$this->title = $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_system', 'User')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=$model->first_name . ' ' . $model->last_name?></h4>
        </div>
        <div class="card-body borderTop">
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-info mb-4">
                        <div class="card-header cardHeader">
                            <img src="<?= (isset($model->picture['uri']) ? Yii::$app->thumbnailer->get($model->picture['uri'], 100, 100, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) : '/img/avatars/1.png') ?>" alt="user profile picture" class="ui-w-100 rounded-circle">
                        </div>
                        <div class="card-body borderTop cardContent">
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_system', 'Country')?></span>: <?= ($model->country ?? Yii::t('core_system','Not Set')) ?>
                            </div>
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_user', 'Personal number')?></span>: <?= ($model->pnr ?? Yii::t('core_system','Not Set')) ?>
                            </div>
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_system', 'Email')?></span>: <?= ($model->email ?? Yii::t('core_system','Not Set')) ?>
                                <?php
                                if ($model->email_status == 'verified' && $model->email !== null) {
                                    echo '<i class="fa fa-check greenColor"></i>';
                                } elseif ($model->email_status == 'unverified' && $model->email !== null) {
                                    echo '<span class="text-warning">' . Yii::t('core_user', '(Unverified)') . '</span>';
                                }
                                ?>
                            </div>
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_system', 'Instance')?></span>: <?= ($model->instance ?? Yii::t('core_system','Not Set')) ?>
                            </div>
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_user', 'Language')?></span>:
                                <?php
                                $userSetting = UserSetting::findSetting($model->id,'language', true);
                                if ($userSetting == null) {
                                    echo Yii::$app->language;
                                } else {
                                    echo $userSetting;
                                }
                                ?>
                            </div>
                            <div class="mb-5">
                                <span class="poppinsStrong"><?=Yii::t('core_user', 'TimeZone')?></span>:
                                <?php
                                $userSetting = UserSetting::findSetting($model->id,'timezone', true);
                                if ($userSetting == null) {
                                    echo Yii::$app->timeZone;
                                } else {
                                    echo $userSetting;
                                }
                                ?>
                            </div>
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_user', 'Registered')?></span>: <?= ($model->registered ? Yii::$app->formatter->asDatetime($model->registered, 'php:Y-m-d H:i') : '') ?>
                            </div>
                            <div>
                                <span class="poppinsStrong"><?=Yii::t('core_user', 'Last login')?></span>: <?=($model->lastUserLogin ? Yii::$app->formatter->asDatetime($model->lastUserLogin->logged, 'php:Y-m-d H:i') . ' view.php' . Yii::t('core_system', 'from') . ' ' . '(' . ($model->lastUserLogin->ip ?? Yii::t('core_system', 'Not Set')) . ')' : Yii::t('core_system', 'Not Set'))?>
                            </div>
                        </div>
                    </div>
                    <div class="card border-info">
                        <div class="card-header cardHeader">
                            <a href="/system-log/index?SystemLogSearch[user_id]=<?=$model->id?>" class="btn btn-warning float-right buttonColor"><i class="fas fa-file-signature"></i> <?=Yii::t('core_system', 'Show All')?></a>
                            <h5><?=Yii::t('core_quick_payment', 'Log')?></h5>
                        </div>
                        <div class="card-body borderTop cardContent indexView">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th><?=Yii::t('core_article', 'Description')?></th>
                                        <th><?=Yii::t('core_system', 'Date')?></th>
                                    </tr>
                                </thead>
                                <?php
                                $systemLogs = SystemLog::find()->where(['user_id' => $model->id,])->orderBy('id DESC')->all();
                                $limitLoop = 1;
                                foreach ($systemLogs as $sL) {
                                    ?>
                                    <tr>
                                        <td><?=$sL['message_short']?></td>
                                        <td><?=Yii::$app->formatter->asDatetime($sL->log_time, 'php:Y-m-d H:i')?></td>
                                    </tr>
                                <?php
                                    if ($limitLoop++ == 10) {
                                        break;
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <?php
                    $organizationRelations = $model->organizationUserRelations;
                    foreach ($organizationRelations as $organizationRelation) {
                        if ($organizationRelation->status === 'accepted') {
                            $organization = $organizationRelation->organization;
                            $userGroupRelations = OrganizationUsergroupUserRelation::find()->where(['ou_relation_id' => $organizationRelation->id])->all();
                            ?>
                            <div class="card border-info mb-4">
                                <div class="card-header cardHeader">
                                    <span class="float-right mt-2">
                                        <?=Yii::t('core_user', 'Registered') . ': ' . Yii::$app->formatter->asDatetime($organizationRelation->added, 'php:Y-m-d H:i')?>
                                    </span>
                                    <h5><?=$organization->name?> - <span class="badge badge-warning badge-pill"><?=Yii::t('organization_user_relation', ucfirst($organizationRelation->title))?></span></h5>
                                </div>
                                <div class="card-body borderTop cardContent indexView">
                                    <?php
                                    if (empty($organization->modules)) {
                                        echo '<h5>' . Yii::t('core_system', 'This organization do not have any module') . '</h5>';
                                    } else {
                                        ?>
                                        <table class="table table-striped">
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
                                            foreach ($organization->modules as $module) {
                                                if ($model->hasAccess($module->id, 'create', false, $organization->id) || $model->hasAccess($module->id, 'read', false, $organization->id) || $model->hasAccess($module->id, 'update', false, $organization->id) || $model->hasAccess($module->id, 'delete', false, $organization->id)) {
                                                    ?>
                                                    <tr>
                                                        <td><?= Yii::t('module', $module->name) ?></td>
                                                        <?php
                                                        $rightArray = ['create', 'read', 'update', 'delete'];
                                                        foreach ($rightArray as $ra) {
                                                            if ($model->getOrganizationUserLevel($organization->id) === 'admin' || $model->getOrganizationUserLevel($organization->id) === 'owner') {
                                                                ?>
                                                                <td class="text-center"><?= ($model->hasAccess($module->id, $ra, true, $organization->id) ?? '<i class="fas fa-times-square fa-2x"></i>') ?></td>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <td class="text-center">
                                                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                                                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0"><?= ($model->hasAccess($module->id, $ra, true, $organization->id) ?? '<i class="fas fa-times-square fa-2x"></i>') ?></span>
                                                                    </span>
                                                                </td>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </table>
                                    <?php
                                    }
                                    echo '<div class="mb-3 ml-3">
                                        <h5>';
                                            if (empty($userGroupRelations)) {
                                                echo Yii::t('core_system', 'This user do not belongs any group');
                                            } else {
                                                echo Yii::t('core_organization', 'User Groups') . ': ';
                                                foreach ($userGroupRelations as $userGroupRealation) {
                                                    echo "<span class='badge badge-pill badge-outline-dark mr-2'><small> ".$userGroupRealation->group->name." </small></span>";
                                                }
                                            }
                                            ?>
                                        </h5>
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
</div>
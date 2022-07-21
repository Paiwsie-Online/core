<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */
/* @var $model common\models\User */

use common\models\core\OrganizationUsergroupUserRelation;
use common\models\OrganizationUserRelation;
use common\models\User;
use common\models\core\UserSetting;
use Imagine\Image\ManipulatorInterface;
use yii\helpers\Html;

?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_user', 'Profile')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=User::getUserName($model->id)?></h4>
        </div>
        <div class="card-body borderTop">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 border-info">
                        <div class="card-header cardHeader">
                            <span class="float-right mt-2">
                                <a href="profile-settings" class="btn buttonTransparent float-right mb-3"><span class="text-muted"><?=Yii::t('core_system', 'Settings')?></span> <i class="fas fa-user-cog text-muted fs-5"></i></a><br>
                                <!--MISSING SOME TABLES FOR MERGE-->
                                <!--<a href="mergeaccounts" class="btn buttonTransparent float-right"><span class="text-muted">< ?=Yii::t('core_user', 'Merge Accounts')?> </span><i class="fas fa-sync-alt fs-5"></i></a>-->
                            </span>
                            <img src="<?= (isset($model->picture['uri']) ? Yii::$app->thumbnailer->get($model->picture['uri'], 100, 100, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) : '/img/avatars/1.png') ?>" alt="user profile picture" class="ui-w-100 rounded-circle">
                        </div>
                        <div class="card-body borderTop cardContent">
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_system', 'Country')?></span>: <?= ($model->country ?? Yii::t('core_system','Not Set')) ?>
                            </div>
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_user', 'Personal number')?></span>: <?=($model->pnr ?? Yii::t('core_system','Not Set'))?>
                            </div>
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_system', 'Email')?></span>: <?= ($model->email ?? Yii::t('core_system','Not Set')) ?>
                                <?php
                                if ($model->email_status == 'verified' && $model->email !== null) {
                                    echo ' <i class="fa fa-check greenColor"></i>';
                                } elseif ($model->email_status == 'unverified' && $model->email !== null) {
                                    echo ' <span class="text-warning">' . Yii::t('core_user', '(Unverified)') . '</span>';
                                }
                                ?>
                            </div>
                            <div class="mb-2">
                                <span class="poppinsStrong"><?=Yii::t('core_system', 'Phone')?></span>: <?= ($model->phone ?? Yii::t('core_system','Not Set')) ?>
                                <?php
                                if ($model->phone_status == 'verified' && $model->phone !== null) {
                                    echo ' <i class="fa fa-check greenColor"></i>';
                                } elseif ($model->phone_status == 'unverified' && $model->phone !== null) {
                                    echo ' <span class="text-warning">' . Yii::t('core_user', '(Unverified)') . '</span>';
                                }
                                ?>
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
                                <span class="poppinsStrong"><?=Yii::t('core_user', 'Last login')?></span>: <?=($model->lastUserLogin ? Yii::$app->formatter->asDatetime($model->lastUserLogin->logged, 'php:Y-m-d H:i') . ' profile.php' . Yii::t('core_system', 'from') . ' ' . '(' . ($model->lastUserLogin->ip ?? Yii::t('core_system', 'Not Set')) . ')' : Yii::t('core_system', 'Not Set'))?>
                            </div>
                        </div>
                    </div>
                    <div class="card border-info">
                        <div class="card-header cardHeader">
                            <h5><?=Yii::t('core_user', 'Athletes')?></h5>
                        </div>
                        <div class="card-body borderTop cardContent">
                            <?php
                      foreach($model->athletes as $athlete) {
                          echo $athlete->first_name . ' ' . $athlete->last_name . '<br>';
                      }
                      $athletes = $model->getAthletes();

   /*                   foreach($model->getAthletes() as $athlete){
                          echo "<pre>";
                          var_dump($athlete->first_name);
                          echo "</pre>";
                      }*/
                            ?>
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
                                    <span class="float-right mt-1">
                                        <?php
                                        $organizationUserRelationArray = OrganizationUserRelation::find()->where(['organization_id' => $organization->id, 'user_level' => 'owner'])->all();
                                        $organizationUserRelation = OrganizationUserRelation::find()->where(['user_id' => $model->id, 'organization_id' => $organization->id])->one();
                                        $counter = count($organizationUserRelationArray);
                                        if ($organizationUserRelation->user_level === 'admin' || $organizationUserRelation->user_level === 'user') {
                                            echo Html::a(Yii::t('core_system', 'Leave organization'), ['delete-from-organization', 'id' => $model->id], [
                                                'class' => 'btn btn-outline-danger',
                                                'data' => [
                                                    'confirm' => Yii::t('core_system', 'Are you sure you want leave this organization?'),
                                                    'method' => 'post',
                                                ],
                                            ]);
                                        } else {
                                            if ($organizationUserRelation->user_level === 'owner' && ($counter !== 0 && $counter !== 1)) {
                                                echo Html::a(Yii::t('core_system', 'Leave organization'), ['delete-from-organization', 'id' => $model->id], [
                                                    'class' => 'btn btn-outline-danger',
                                                    'data' => [
                                                        'confirm' => Yii::t('core_system', 'Are you sure you want leave this organization?'),
                                                        'method' => 'post',
                                                    ],
                                                ]);
                                            } else {
                                                echo '<a class="btn btn-outline-secondary disabled">' . Yii::t('core_system', 'Leave organization') . '</a>';
                                            }
                                        }
                                        ?>
                                    </span>
                            <h5><?=$organization->name?> - <span class="badge badge-warning badge-pill"><?=Yii::t('organization_user_relation', ucfirst($organizationRelation->user_level))?></span></h5>
                        </div>
                        <div class="card-body borderTop cardContent indexView">
                            <?php
                            if (empty($organization->modules)) {
                                echo '<h5>' . Yii::t('core_system', 'This organization do not have any module') . '</h5>';
                            } else {
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
                                    foreach ($organization->modules as $module) {
                                        if ($model->hasAccess($module->id, 'create', false, $organization->id) || $model->hasAccess($module->id, 'read', false, $organization->id) || $model->hasAccess($module->id, 'update', false, $organization->id) || $model->hasAccess($module->id, 'delete', false, $organization->id)) {
                                            ?>
                                            <tr>
                                                <td><?=Yii::t('module', $module->name)?></td>
                                                <?php
                                                $rightArray = ['create', 'read', 'update', 'delete'];
                                                foreach ($rightArray as $ra) {
                                                    if ($model->getOrganizationUserLevel($organization->id) === 'admin' || $model->getOrganizationUserLevel($organization->id) === 'owner') {
                                                        ?>
                                                        <td class="text-center"><?= ($model->hasAccess($module->id, $ra, true, $organization->id) ?? '<i class="fas fa-times-square fa-2x text-danger"></i>') ?></td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td class="text-center">
                                                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                                                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0"><?= ($model->hasAccess($module->id, $ra, true, $organization->id) ?? '<i class="fas fa-times-square fa-2x text-danger"></i>') ?></span>
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
                                    echo "<span class='badge badge-pill badge-outline-dark mr-2'><small>" . $userGroupRealation->group->name . "</small></span> ";
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
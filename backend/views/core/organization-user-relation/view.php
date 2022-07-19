<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\Organization;
use common\models\core\OrganizationModuleRelation;
use common\models\core\OrganizationUsergroupUserRelation;
use common\models\core\OrganizationUserModuleRight;
use common\models\core\OrganizationUserRelation;
use common\models\core\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\OrganizationUserRelation */

$user = User::findIdentity($model->user_id);

$this->title = (isset($user->first_name) ? $user->first_name.' '.($user->last_name ?? '') : Yii::t('core_system', 'Not Set'));
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', '{organization} users', ['organization' => Yii::$app->user->identity->selectedOrganization['name']]), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$organization = Organization::find()->where(['id' => $model->organization_id])->one();
$groups = Yii::$app->user->identity->selectedOrganization->getGroupListUserRelation($model->id);
?>


<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="col-12 mb-4">
    <div class="card">
        <div class="card-header">
            <span class="float-right mt-2">
                <?= Html::a(Yii::t('core_system', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning mr-3']) ?>
                <?php
                $organizationUserRelationArray = OrganizationUserRelation::find()->where(['organization_id' => Yii::$app->user->identity->selectedOrganization->id, 'user_level' => 'owner'])->all();
                $counter = count($organizationUserRelationArray);
                if ($model->user_level === 'admin' || $model->user_level === 'user') {
                    echo Html::a(($model->user_id === Yii::$app->user->identity->id ? Yii::t('core_system', 'Leave organization') : Yii::t('core_system', 'Delete')), ['delete-from-organization', 'id' => $model->id], [
                        'class' => 'btn btn-outline-danger',
                        'data' => [
                            'confirm' => Yii::t('core_system', 'Are you sure you want to remove this user?'),
                            'method' => 'post',
                        ],
                    ]);
                }
                if ($model->user_level === 'owner' && ($counter !== 0 && $counter !== 1)) {
                    echo Html::a(($model->user_id === Yii::$app->user->identity->id ? Yii::t('core_system', 'Leave organization') : Yii::t('core_system', 'Delete')), ['delete-from-organization', 'id' => $model->id], [
                        'class' => 'btn btn-outline-danger',
                        'data' => [
                            'confirm' => Yii::t('core_system', 'Are you sure you want to remove this user?'),
                            'method' => 'post',
                        ],
                    ]);
                }
                ?>
            </span>
            <h4><?=Yii::t('core_system', 'Modules right')?></h4>
        </div>
        <div class="card-body indexView">
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
                    ?>
                    <tr>
                        <td>
                            <?=Yii::t('module', $module->name) ?>
                            <?php
                            $organizationModuleRelation = OrganizationModuleRelation::findOne(['organization_id' => $model->organization_id, 'module_id' => $module->id]);
                            if ($organizationModuleRelation) {
                                $userRights = OrganizationUserModuleRight::findOne(['ou_relation_id' => $model->id, 'cmr_id' => $organizationModuleRelation->id]);
                                if (isset($userRights)) {
                                    if ($userRights->right_create !== 2 || $userRights->right_read !== 2 || $userRights->right_update !== 2 || $userRights->right_delete !== 2) {
                                        echo Html::a(Yii::t('core_system', 'Remove individual rights'), ['/organization-user-module-right/remove-individual-rights', 'ou_relation_id' => $model->id, 'cmr_id' => $organizationModuleRelation->id], [
                                            'class' => 'btn btn-warning btn-sm float-right black',
                                            'data' => [
                                                'confirm' => Yii::t('core_system', 'Are you sure you want to remove individual rights this user?'),
                                                'method' => 'post',
                                            ],
                                        ]);
                                    }
                                }
                            }
                            ?>
                        </td>
                        <?php
                        $rightArray = ['create', 'read', 'update', 'delete'];
                        foreach ($rightArray as $ra) {
                            if ($user->getOrganizationUserLevel($model->organization_id) === 'admin' || $user->getOrganizationUserLevel($model->organization_id) === 'owner') {
                                ?>
                                <td class="text-center"><?= ($user->hasAccess($module->id, $ra, true) ?? '<i class="fas fa-times-square fa-2x"></i>') ?></td>
                                    <?php
                            } else {
                            ?>
                            <td class="text-center">
                                <a class="dropdown-toggle hide-arrow" href="#" data-toggle="dropdown" aria-expanded="false">
                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0"><?= ($user->hasAccess($module->id, $ra, true) ?? '<i class="fas fa-times-square fa-2x"></i>') ?></span>
                                    </span>
                                </a>
                                <div class="dropdown-menu">
                                    <?= Html::a('<i class="far fa-check-square fa-2x"></i> ' . Yii::t('core_system', 'Has access'), ['/organization-user-module-right/update-rights', 'ou_relation_id' => $model->id, 'module_id' => $module->id, 'right' => $ra, 'value' => 1], [
                                        'class' => 'dropdown-item',
                                        'data' => [
                                            'method' => 'post',
                                        ],
                                    ]);?>
                                    <?= Html::a('<i class="far fa-times-square fa-2x"></i> ' . Yii::t('core_system', 'No access'), ['/organization-user-module-right/update-rights', 'ou_relation_id' => $model->id, 'module_id' => $module->id, 'right' => $ra, 'value' => 0], [
                                        'class' => 'dropdown-item',
                                        'data' => [
                                            'method' => 'post',
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </td>
                            <?php
                            }
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <span class="float-right mt-2">
                <?= Html::a('+ ' . Yii::t('core_organization', 'Add group'), ['/organization-usergroup-user-relation/add-group', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            </span>
            <h4><?=Yii::t('core_organization', 'Group memberships')?></h4>
        </div>
        <?php
        if ($groups) {
            ?>
            <div class="card-body indexView">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?=Yii::t('core_organization', 'Group name')?></th>
                        <th><?=Yii::t('core_system', 'Added By')?></th>
                        <th><?=Yii::t('core_system', 'Added Time')?></th>
                        <th class="text-right"><?=Yii::t('core_system', 'Options')?></th>
                    </tr>
                    </thead>
                    <?php
                    foreach (array_reverse($groups) as $group) {
                        $organizationUserGroupRelation = OrganizationUsergroupUserRelation::find()->where(['ou_relation_id'=> $model->id, 'group_id' => $group->id])->one();
                        ?>
                        <tr>
                            <td><a href="/organization-usergroup/view?id=<?=$organizationUserGroupRelation->group_id?>"><?= $group->name ?></a></td>
                            <td><!--<a href="/organization-user-relation/view?id=< ?=$organizationUserGroupRelation->ou_relation_id?>">--><?=User::getUserName($organizationUserGroupRelation->created_by)?><!--</a>--></td>
                            <td><?= Yii::$app->formatter->asDatetime($organizationUserGroupRelation->created_at, 'php:Y-m-d H:i') ?></td>
                            <td class="text-right"><?= Html::a(Yii::t('core_system', 'Delete'), ['/organization-usergroup-user-relation/delete', 'id' => $organizationUserGroupRelation->id], [
                                    'class' => 'btn btn-outline-danger',
                                    'data' => [
                                        'confirm' => Yii::t('core_system', 'Are you sure you want to remove this user from this group?'),
                                        'method' => 'post',
                                    ],
                                ]) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <?php
            } else {
                ?>
                <div class="card-body">
                    <div class="empty">
                        <i class="fas fa-info-circle fs-5"></i> <?=(isset($user->first_name) ? $user->first_name . ' ' . ($user->last_name ?? '') : '') . ' ' . Yii::t('core_organization', 'is not in any group')?>
                    </div>
                </div>
            <?php
            }
            ?>
    </div>
</div>
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\OrganizationUserRelation;
use common\models\core\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\OrganizationUsergroup */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_organization', '{organization} user groups', ['organization' => Yii::$app->user->identity->selectedOrganization['name']]), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_organization', 'User groups')?></h2>
</div>
<div class="col-12 mb-4">
    <div class="card">
        <div class="card-header">
            <span class="float-right mt-2">
                <?= Html::a(Yii::t('core_organization', 'Change group name'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning mr-3']) ?>
                <?= Html::a(Yii::t('core_system', 'Delete'), ['delete-from-organization', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data' => [
                        'confirm' => Yii::t('core_system', 'Are you sure you want to delete this group?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </span>
            <h4><?=Yii::t('core_organization', 'Group Access')?> <small><small class="text-muted"><?= Yii::t('core_system', 'Created By') . ' view.php' . (isset($model->created_by) ? User::getUserName($model->created_by) : Yii::t('core_system', 'Not Set')) . ' ' . $model->created ?></small></small></h4>
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
                foreach ($model->organization->modules as $module) {
                ?>
                    <tr>
                        <td><?=Yii::t('module', $module->name)?></td>
                        <?php
                        $rightArray = ['create', 'read', 'update', 'delete'];
                        foreach ($rightArray as $ra) {
                        ?>
                            <td class="text-center"><a class="dropdown-toggle hide-arrow" href="#" data-toggle="dropdown" aria-expanded="false">
                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                        <span id="language" class="px-1 mr-lg-2 ml-2 ml-lg-0"><?= ($model->hasAccess($module->id, $ra, $model->id, $model->organization_id) ? '<i class="fas fa-check-square fa-2x"></i>' : '<i class="fas fa-times-square fa-2x"></i>') ?></span>
                                        </span>
                                </a>
                                <div class="dropdown-menu">
                                    <?= Html::a('<i class="fas fa-check-square fa-2x"></i> ' . Yii::t('core_system', 'Has access'), ['/organization-group-module-right/update-rights', 'group_id' => $model->id, 'module_id' => $module->id, 'right' => $ra, 'value' => 1], [
                                                'class' => 'dropdown-item',
                                                'data' => [
                                                    'method' => 'post',
                                                ],
                                            ]);?>
                                    <?= Html::a('<i class="fas fa-times-square fa-2x"></i> ' . Yii::t('core_system', 'No access'), ['/organization-group-module-right/update-rights', 'group_id' => $model->id, 'module_id' => $module->id, 'right' => $ra, 'value' => 0], [
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
            <span class="float-right mt-2"><?= Html::a('+ ' . Yii::t('core_organization', 'Add user'), ['add-user', 'id' => $model->id], ['class' => 'btn btn-warning']) ?></span>
            <h4><?=Yii::t('core_organization', 'User of this group')?></h4>
        </div>
        <?php
        if ($model->organizationUsergroupUserRelations) {
            ?>
            <div class="card-body indexView">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?=Yii::t('core_system', 'User')?></th>
                        <th><?=Yii::t('core_system', 'Added By')?></th>
                        <th><?=Yii::t('core_system', 'Added Time')?></th>
                        <th class="text-right"><?=Yii::t('core_system', 'Options')?></th>
                    </tr>
                    </thead>
                    <?php
                    foreach (array_reverse($model->organizationUsergroupUserRelations) as $user) {
                        $added_byOu_relation_id = OrganizationUserRelation::find()->where(['organization_id' => $model->organization_id, 'user_id' => $user->added_by])->one();
                        ?>
                        <tr>
                            <td><a href="/organization-user-relation/view?id=<?=$user->ou_relation_id?>"><?= User::getUserName($user->cuRelation->user->id) ?></a></td>
                            <td><?=($added_byOu_relation_id ? /*'<a href="/organization-user-relation/view?id=' . $added_byOu_relation_id->id . '">' .*/ User::getUserName($user->added_by) /*. '</a>'*/ : User::getUserName($user->added_by)) ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($user->added, 'php:Y-m-d H:i') ?></td>
                            <td class="text-right"><?= Html::a(Yii::t('core_system', 'Delete'), ['/organization-usergroup-user-relation/delete', 'id' => $user->id], [
                                    'class' => 'btn btn-outline-danger',
                                    'data' => [
                                        'confirm' => Yii::t('core_system', 'Are you sure you want to remove this user?'),
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
                    <i class="fas fa-info-circle fs-5"></i> <?=Yii::t('core_system', 'There are not users in this group')?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */
/* @var $type */
/* @var $dates */
/* @var $timeArray */
/* @var $datesArrayValues */
/* @var $blockOrder */

use common\models\core\OrganizationModuleRelation;
use common\models\core\OrganizationUserRelation;
use common\models\core\UserSetting;
use Imagine\Image\ManipulatorInterface;
use yii\bootstrap5\Html;

/*testing private fork update*/

$this->title = Yii::t('core_system', 'Home');

$this->registerJsFile('@web/js/pageScripts/index.js',['depends' => [\yii\web\JqueryAsset::className()]]);

if (isset(Yii::$app->user->identity->selectedOrganization->id)) {
    $organizationModulesCount = (int)OrganizationModuleRelation::find()->where(['organization_id' => Yii::$app->user->identity->selectedOrganization->id])->count();
}
if ((isset($organizationModulesCount) && $organizationModulesCount === 0) || !isset($organizationModulesCount)) {
    ?>
    <div class="col-12 border-rounded mt-4 mb-3">
        <div class="d-inline-flex">
            <div class="mt-4 mb-4 ml-2">
                <img class="rounded-circle img-fluid" src="<?= Yii::$app->thumbnailer->get(Yii::$app->params['branding']['lightLogo'], 100, 100, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) ?>">
            </div>
        </div>
        <div class="d-inline-flex">
            <div class="mt-4 mb-4 ml-2">
                <h1><?= Yii::t('core_system', 'Welcome to') . ' ' . Yii::$app->params['default_site_settings']['site_name']?></h1>
                <span class="mt-2"><?=Yii::t('core_system', 'Smart payments as a service')?></span>
            </div>
        </div>
    </div>
    <?php
}
?>
<div class="row">
    <?php
    $userInvitations = OrganizationUserRelation::find()->where(['user_id' => Yii::$app->user->identity->id, 'status' => 'pending'])->all();
    if (empty($userInvitations)) {
        $userInvitations = OrganizationUserRelation::find()->select(['organization_user_relation.*'])->leftJoin('organization_user_relation_invitation ouri', 'ouri.our_id=organization_user_relation.id')->where(['organization_user_relation.user_id' => null, 'organization_user_relation.status' => 'pending', 'ouri.sent_to' => Yii::$app->user->identity->phone])->all();
    }
    if (!empty($userInvitations)) {
        ?>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h4><?= Yii::t('core_system', 'You have {numInvites, plural, =0{no} =1{one} other{#}} new {numInvites, plural, =0{invitations} =1{invitation} other{invitations}}!', ['numInvites' => count($userInvitations)]) ?></h4>
                </div>
                <div class="card-body borderTop indexView">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?=Yii::t('core_organization', 'Organization')?></th>
                                <th><?=Yii::t('core_organization', 'Role')?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($userInvitations as $userInvitation) {
                            ?>
                            <tr>
                                <td><?= $userInvitation->organization->name ?></td>
                                <td><?= Yii::t('organization_user_relation', $userInvitation->user_level) ?></td>
                                <td><?= Html::a(Yii::t('core_system', 'Decline'), ['/organization-user-relation/respond-invitation', 'id' => $userInvitation->id, 'response' => 'declined'], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => Yii::t('core_system', 'Are you sure you want to decline the invitation from {organization}?', ['organization' => $userInvitation->organization->name]),
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                    <?= Html::a(Yii::t('core_system', 'Accept'), ['/organization-user-relation/respond-invitation', 'id' => $userInvitation->id, 'response' => 'accepted'], [
                                        'class' => 'btn btn-success',
                                        'data' => [
                                            'confirm' => Yii::t('core_system', 'Are you sure you want to accept the invitation from {organization}?', ['organization' => $userInvitation->organization->name]),
                                            'method' => 'post',
                                        ],
                                    ]) ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <?php
    if (!isset(Yii::$app->user->identity->selectedOrganization)) {
        if (count(Yii::$app->user->identity->organizationList) === 0) {
            ?>
            <div class="col-md-4">
                <div class="card mb-3 h-100">
                    <div class="card-header">
                        <h4><?= Yii::t('core_system', 'Welcome to') . ' ' .Yii::$app->params['default_site_settings']['site_name']?></h4>
                    </div>
                    <div class="card-body borderTop">
                        <?=Yii::t('core_system', '<p>Thank you for registering an account!</p><p>In order for you to get started on the right track we have prepared a startup guide for you.</p>')?>
                        <button type="button" onclick="getstartednewuser();" class="btn btn-success w-100"><?=Yii::t('core_system', 'Get started')?></button>
                    </div>
                </div>
            </div>
            <?php
            if (count($userInvitations) === 0) {
            ?>
                <div class="col-md-4">
                    <div class="card mb-3 h-100">
                        <div class="card-body">
                            <?=Yii::t('core_system', '<p>If you have received an invitation,</p><p>please, go to your mail and click to the link.</p>')?>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
    }
    ?>
</div>

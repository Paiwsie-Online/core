<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use common\models\core\Organization;
use common\models\core\User;

/* @var $this yii\web\View */
/* @var $model common\models\core\SystemLog */

$this->title = $model->message_short;
$this->params['breadcrumbs'][] = ['label' => Yii::t('core_system','System Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Yii::t('core_quick_payment', 'Log')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4><?=$model->message_short?></h4>
        </div>
        <div class="card-body indexView">
            <table class="table table-striped" style="width: 100%">
                <tr>
                    <td class="poppinsStrong"><?=Yii::t('core_system', 'User')?></td>
                    <td><?=User::getUserName($model->user_id)?></td>
                </tr>
                <tr>
                    <td class="poppinsStrong"><?=Yii::t('core_organization', 'Organization')?></td>
                    <td><?=Organization::getOrganizationName($model->organization_id)?></td>
                </tr>
                <tr>
                    <td class="poppinsStrong"><?=Yii::t('core_system', 'Message')?></td>
                    <td><?=$model->message?></td>
                </tr>
                <tr>
                    <td class="poppinsStrong"><?=Yii::t('core_system', 'Log Time')?></td>
                    <td><?=($model->created_at ? Yii::$app->formatter->asDatetime($model->created_at, 'php:Y-m-d H:i') : Yii::t('core_system', 'Not Set'))?></td>
                </tr>
                <?php
                if ($model->instance !== null) {
                    ?>
                    <tr>
                        <td class="poppinsStrong"><?=Yii::t('core_system', 'Instance')?></td>
                        <td><?=$model->instance?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>
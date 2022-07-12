<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */
/* @var $model common\models\core\User */

use common\models\core\Enumeration;
use common\models\core\User;
use common\models\core\UserSetting;
use Imagine\Image\ManipulatorInterface;
use yii\helpers\Html;

?>

<div class="row">
    <div class="col-xl-4">

        <!-- Side info -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="<?= (isset($model->picture['uri']) ? Yii::$app->thumbnailer->get($model->picture['uri'], 100, 100, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) : '/img/avatars/1.png') ?>" alt="user profile picture" class="ui-w-100 rounded-circle float-left mr-3">
                        <h5 class="mt-3"> <?= User::getUserName($model->id) ?></h5>
                    </div>
                    <div class="col-md-6">
                        <?php
                        echo '<span class="float-right text-right">';
                            if (($model->email_status === 'verified' || $model->phone_status === 'verified') && isset($model->password)) {
                                echo '<a href="pwchange" class="btn btn-primary mb-2 btn-sm">' . Yii::t('core_system', 'Change Password') . '</a><br>';
                            }
                            if (Yii::$app->params['loginOptions']['allowEmail'] === true) {
                                if ($model->email_status === 'verified') {
                                    echo '<a href="emailchange" class="btn btn-primary mb-2 btn-sm">' . Yii::t('core_system', 'Change Email') . '</a><br>';
                                }
                                if (!isset($model->email_status) && !isset($model->password)) {
                                    echo '<a href="addemailpw" class="btn btn-primary mb-2 btn-sm">' . Yii::t('core_system', 'Add Email and Password') . '</a><br>';
                                }
                                if (!isset($model->email_status) && isset($model->phone)) {
                                    echo '<a href="addemail" class="btn btn-primary mb-2 btn-sm">' . Yii::t('core_system', 'Add Email') . '</a><br>';
                                }
                                if (isset($model->email) && $model->email_status === 'unverified') {
                                    echo '<a href="resend-verification-email" class="btn btn-success mb-2 btn-sm">' . Yii::t('core_system', 'Resend Email') . '</a><br>';
                                }
                            }
                            if (Yii::$app->params['loginOptions']['allowPhone'] === true) {
                                if ($model->phone_status === 'verified') {
                                    echo '<a href="phone-change" class="btn btn-primary mb-2 btn-sm">' . Yii::t('core_system', 'Change Phone') . '</a><br>';
                                }
                                if (!isset($model->phone_status) && !isset($model->password)) {
                                    echo '<a href="add-mobilepw" class="btn btn-primary mb-2 btn-sm">' . Yii::t('core_system', 'Add Phone and Password') . '</a><br>';
                                }
                                if (!isset($model->phone_status) && isset($model->email)) {
                                    echo '<a href="add-mobile" class="btn btn-primary mb-2 btn-sm">' . Yii::t('core_system', 'Add Phone') . '</a><br>';
                                }
                                if (isset($model->phone) && $model->phone_status === 'unverified') {
                                    echo '<a href="resend-verification-mobile" class="btn btn-success mb-2 btn-sm">' . Yii::t('core_system', 'Resend Phone') . '</a><br>';
                                }
                            }
                            if (Yii::$app->params['loginOptions']['allowQR'] === true) {
                                if (!isset($model->country) && !isset($model->pnr)) {
                                    echo '<a href="addtagid" class="btn btn-primary btn-sm">' . Yii::t('core_system', 'Add TagID') . '</a>';
                                }
                            }
                        echo '</span>';
                        ?>
                    </div>
                </div>
            </div>
            <hr class="border-light m-0">
            <div class="card-body">
                <div class="mb-2">
                    <span class="text-muted"><?=Yii::t('core_system', 'Country')?></span>&nbsp;
                    <?= ($model->country ?? Yii::t('core_system','Not Set')) ?>
                </div>
                <div class="mb-2">
                    <span class="text-muted"><?=Yii::t('core_user', 'Personal number')?>:</span>&nbsp;
                    <?= ($model->pnr ?? Yii::t('core_system','Not Set')) ?>
                </div>
                <div class="mb-2">
                    <span class="text-muted"><?=Yii::t('core_system', 'Email')?>:</span>&nbsp;
                    <?= ($model->email ?? Yii::t('core_system','Not Set')) ?>
                    <?php
                    if ($model->email_status == 'verified') {
                        echo ' <i class="fa fa-check text-success"></i>';
                    } elseif ($model->email_status == 'unverified') {
                        echo ' <span class="text-danger">' . Yii::t('core_user', '(Unverified)') . '</span>';
                    }
                    ?>
                </div>
                <div class="mb-2">
                    <span class="text-muted"><?=Yii::t('core_system', 'Phone')?></span>: <?= ($model->phone ?? Yii::t('core_system','Not Set')) ?>
                    <?php
                    if ($model->phone_status == 'verified') {
                        echo ' <i class="fa fa-check text-success"></i>';
                    } elseif ($model->phone_status == 'unverified') {
                        echo ' <span class="text-danger">' . Yii::t('core_user', '(Unverified)') . '</span>';
                    }
                    ?>
                </div>
                <div class='mb-2'>
                    <span class="text-muted"><?=Yii::t('core_user', 'Language')?>:</span>&nbsp;
                    <?php
                    $userSetting = UserSetting::findSetting($model->id,'language', true);
                    if ($userSetting == null) {
                        echo Yii::$app->language;
                    } else {
                        echo $userSetting;
                    }
                    ?>
                </div>
                <div class='mb-4'>
                    <span class="text-muted"><?=Yii::t('core_user', 'TimeZone')?>:</span>&nbsp;
                    <a class="dropdown text-dark" href="#" data-toggle="dropdown" aria-expanded="false">
                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0">
                            <?php
                            $userSetting = UserSetting::findSetting($model->id,'timezone', true);
                            if ($userSetting == null) {
                                echo Yii::$app->timeZone . ' ' . '<i class="far fa-angle-down"></i>';
                            } else {
                                echo $userSetting  . ' ' . '<i class="far fa-angle-down"></i>';
                            }
                            ?>
                        </span>
                    </a>
                    <div class="dropdown-menu" style="max-height: 300px; overflow-y: auto">
                        <?php
                        $timezones = Enumeration::get_list('timezone');
                        foreach ($timezones as $key => $value) {
                            echo Html::a($value, ['user-setting/set', 'setting' => 'timezone', 'value' => $value], [
                                'class' => 'dropdown-item',
                                'data' => [
                                    'method' => 'post',
                                ],
                            ]);
                        }
                        ?>
                    </div>
                </div>
                <div class='mb-2'>
                    <span class="text-muted"><?=Yii::t('core_user', 'Registered')?>:</span>&nbsp;
                    <?= ($model->registered ? Yii::$app->formatter->asDatetime($model->registered, 'php:Y-m-d H:i') : '') ?>
                </div>
                <div>
                    <span class="text-muted"><?=Yii::t('core_user', 'Last login')?>:</span>&nbsp;
                    <?=Yii::$app->formatter->asDatetime($model->lastUserLogin->logged, 'php:Y-m-d H:i')?> from (<?= ($model->lastUserLogin->ip ?? Yii::t('core_system', 'Not Set')) ?>)
                </div>
                <span class="float-right">
                    <a href="profile" class="btn btn-secondary btn-sm"> <?=Yii::t('core_system', 'Back')?></a>
                </span>
            </div>
        </div>
    </div>
</div>
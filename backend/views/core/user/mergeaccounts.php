<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */
/* @var $model common\models\core\User */
/* @var $secondAccountLogin common\models\core\LoginForm */
/* @var $secondAccount common\models\core\User */

use common\models\core\User;
use common\models\core\UserSetting;
use Imagine\Image\ManipulatorInterface;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerMetaTag([
    'name' => 'NEURON',
    'content' => Yii::$app->params['tagID_settings']['neuron']
]);
$this->registerJsFile("https://".Yii::$app->params['tagID_settings']['neuron']."/Events.js");
$this->registerJsFile("@web/js/QuickLogin.js");

$this->title = Yii::t('core_user', 'Merge accounts');
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=Html::encode($this->title)?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="float-right"><?=Yii::t('core_user', 'Secondary Account')?></h4>
            <h4><?=Yii::t('core_user', 'Current Account')?></h4>
        </div>
        <div class="card-body borderTop">
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-header cardHeader">
                            <h6 class="float-right"><?= User::getUserName($model->id) ?></h6>
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
                                <span class="poppinsStrong"><?=Yii::t('core_system', 'Email')?></span>: <?=($model->email ?? Yii::t('core_system','Not Set'))?>
                                <?php
                                if ($model->email_status == 'verified' && $model->email !== null) {
                                    echo ' <i class="fa fa-check text-success"></i>';
                                } elseif ($model->email_status == 'unverified' && $model->email !== null) {
                                    echo ' <span class="text-danger">' . Yii::t('core_user', '(Unverified)') . '</span>';
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
                                <span class="poppinsStrong"><?=Yii::t('core_user', 'Last login')?></span>: <?=($model->lastUserLogin ? Yii::$app->formatter->asDatetime($model->lastUserLogin->logged, 'php:Y-m-d H:i') . ' mergeaccounts.php' . Yii::t('core_system', 'from') . ' ' . '(' . ($model->lastUserLogin->ip ?? Yii::t('core_system', 'Not Set')) . ')' : Yii::t('core_system', 'Not Set'))?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php
                    if ($secondAccount !== null && $secondAccount->id !== Yii::$app->user->identity->id) {
                        ?>
                        <div class="mt-5 mt-5 pt-5">
                            <?=Html::a('<span class="float-left"><i class="fas fa-trash-alt"></i> ' . Yii::t('core_system', 'Delete') . '</span><i class="fas fa-arrow-right"></i><span class="float-right">' . Yii::t('core_clipcard', 'Use') . ' <i class="fas fa-check"></i></span>', ['merge-accounts-confirm', 'mergeInto' => 1], [
                                'class' => 'btn btn-warning w-100',
                                'data' => [
                                    'confirm' => Yii::t('core_system', 'Are you sure you want to merge to this account?'),
                                    'method' => 'post',
                                ],
                            ])?>
                        </div>
                        <div class="mt-5 mt-5 pt-5">
                            <?=Html::a('<span class="float-left"><i class="fas fa-check"></i> ' . Yii::t('core_clipcard', 'Use') . '</span><i class="fas fa-arrow-left"></i><span class="float-right">' . Yii::t('core_system', 'Delete') . ' <i class="fas fa-trash-alt"></i></span>', ['merge-accounts-confirm', 'mergeInto' => 2], [
                                'class' => 'btn btn-warning w-100',
                                'data' => [
                                    'confirm' => Yii::t('core_system', 'Are you sure you want to merge from this account?'),
                                    'method' => 'post',
                                ],
                            ])?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-md-4">
                    <div class="card border-info">
                        <?php
                        if ($secondAccount === null) {
                            ?>
                            <div class="card-body cardContent" id="buttonsLogin">
                                <div class="mb-4">
                                    <?=Yii::t('core_user', 'Select the method that you want to login secondary account.')?>
                                </div>
                                <div class="mt-4">
                                    <button type="button" class="btn btn-warning" onclick="blockSwitch('#emailLogin', '#buttonsLogin')"><?=Yii::t('core_system', 'Email Login')?></button>
                                    <button type="button" class="btn btn-warning float-right" onclick="blockSwitch('#QRLogin', '#buttonsLogin')"><?=Yii::t('core_system', 'QR Login')?></button>
                                </div>
                            </div>
                            <div class="card-body cardContent" id="emailLogin" style="display:none">
                                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                                <?= $form->field($secondAccountLogin, 'email')->textInput(['autofocus' => false]) ?>
                                <?= $form->field($secondAccountLogin, 'password')->passwordInput() ?>
                                <?= Html::submitButton(Yii::t('core_system', 'Login'), ['class' => 'btn w-100 btn-warning', 'name' => 'login-button']) ?>
                                <?php ActiveForm::end(); ?>
                                <br><button type="button" class="btn btn-secondary" onclick="blockSwitch('#buttonsLogin', '#emailLogin')"><?=Yii::t('core_system', 'Back')?></button>
                            </div>
                            <div class="card-body cardContent" id="QRLogin" style="display:none">
                                <?php
                                $scanSession = \Yii::$app->security->generateRandomString();
                                $_SESSION['tagScanSession'] = $scanSession;
                                $_SESSION['tagScanPurpose'] = 'mergeQRAccount';
                                $data = [
                                    'service'   =>  Yii::$app->params['tagID_settings']['service_callback_url'],
                                    'sessionId' =>  $scanSession
                                ];
                                $jsonPost = json_encode($data);
                                $ch = curl_init("https://".Yii::$app->params['tagID_settings']['neuron']."/QuickLogin");
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); //true
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); //2
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPost);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Accept: application/json"));
                                $response = curl_exec($ch);
                                curl_close($ch);
                                $responseDecoded = json_decode($response, true);
                                ?>
                                <div id="quickLoginCode" data-serviceID="<?= $responseDecoded['serviceId'] ?>" data-mode="image" data-purpose="Identify yourself against <?= Yii::$app->params['default_site_settings']['site_name'] ?>" style="text-align: center;">
                                </div>
                                <button type="button" class="btn btn-secondary" onclick="blockSwitch('#buttonsLogin', '#QRLogin')"><?=Yii::t('core_system', 'Back')?></button>
                            </div>
                        <?php
                        } elseif ($secondAccount !== null && $secondAccount->id !== Yii::$app->user->identity->id) {
                        ?>
                            <div class="card">
                                <div class="card-header cardHeader">
                                    <h6 class="float-right"><?= User::getUserName($secondAccount->id) ?></h6>
                                    <img src="<?= (isset($secondAccount->picture['uri']) ? Yii::$app->thumbnailer->get($secondAccount->picture['uri'], 100, 100, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) : '/img/avatars/1.png') ?>" alt="user profile picture" class="ui-w-100 rounded-circle">
                                </div>
                                <div class="card-body borderTop cardContent">

                                    <div class="mb-2">
                                        <span class="poppinsStrong"><?=Yii::t('core_system', 'Country')?></span>: <?= ($secondAccount->country ?? Yii::t('core_system','Not Set')) ?>
                                    </div>
                                    <div class="mb-2">
                                        <span class="poppinsStrong"><?=Yii::t('core_user', 'Personal number')?></span>: <?= ($secondAccount->pnr ?? Yii::t('core_system','Not Set')) ?>
                                    </div>
                                    <div class="mb-2">
                                        <span class="poppinsStrong"><?=Yii::t('core_system', 'Email')?></span>:
                                        <?= ($secondAccount->email ?? Yii::t('core_system','Not Set')) ?>
                                        <?php
                                        if ($secondAccount->email_status == 'verified' && $secondAccount->email !== null) {
                                            echo '<i class="fa fa-check text-success"></i>';
                                        } elseif ($secondAccount->email_status == 'unverified' && $secondAccount->email !== null) {
                                            echo '<span class="text-danger">' . Yii::t('core_user', '(Unverified)') . '</span>';
                                        }
                                        ?>
                                    </div>
                                    <div class="mb-2">
                                        <span class="poppinsStrong"><?=Yii::t('core_user', 'Language')?></span>:
                                        <?php
                                        $userSetting = UserSetting::findSetting($secondAccount->id,'language', true);
                                        if ($userSetting == null) {
                                            echo Yii::t('core_system','Not Set');
                                        } else {
                                            echo $userSetting;
                                        }
                                        ?>
                                    </div>
                                    <div class="mb-5">
                                        <span class="poppinsStrong"><?=Yii::t('core_user', 'TimeZone')?></span>:
                                        <?php
                                        $userSetting = UserSetting::findSetting($secondAccount->id,'timezone', true);
                                        if ($userSetting == null) {
                                            echo Yii::t('core_system','Not Set');
                                        } else {
                                            echo $userSetting;
                                        }
                                        ?>
                                    </div>
                                    <div class="mb-2">
                                        <span class="poppinsStrong"><?=Yii::t('core_user', 'Registered')?></span>: <?= ($secondAccount->registered ? Yii::$app->formatter->asDatetime($secondAccount->registered, 'php:Y-m-d H:i') : '') ?>
                                    </div>
                                    <div>
                                        <span class="poppinsStrong"><?=Yii::t('core_user', 'Last login')?></span>: <?=($secondAccount->lastUserLogin ? Yii::$app->formatter->asDatetime($secondAccount->lastUserLogin->logged, 'php:Y-m-d H:i') . ' mergeaccounts.php' . Yii::t('core_system', 'from') . ' ' . '(' . ($secondAccount->lastUserLogin->ip ?? Yii::t('core_system', 'Not Set')) . ')' : Yii::t('core_system', 'Not Set'))?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } elseif ($secondAccount !== null && $secondAccount->id === Yii::$app->user->identity->id) {
                            ?>
                            <div class="card">
                                <div class="card-body cardContent">
                                    <div class="mb-4 text-danger">
                                        <?=Yii::t('core_user', 'You can not merge to the same account, please try again.')?>
                                    </div>
                                    <div>
                                        <?=Html::a(Yii::t('core_system', 'Try again'), ['mergeaccounts'], [
                                            'class' => 'btn btn-warning',
                                            'data' => [
                                                'method' => 'post',
                                            ],
                                        ])?>
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
    </div>
</div>
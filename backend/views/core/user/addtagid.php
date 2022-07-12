<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */
/* @var $model common\models\core\User */

use common\models\core\User;
use Imagine\Image\ManipulatorInterface;

$this->registerMetaTag([
    'name' => 'NEURON',
    'content' => Yii::$app->params['tagID_settings']['neuron']
]);
$this->registerJsFile("https://".Yii::$app->params['tagID_settings']['neuron']."/Events.js");
$this->registerJsFile("@web/js/QuickLogin.js");

?>

<div class="row">
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="media">
                    <img src="<?= (isset($model->picture['uri']) ? Yii::$app->thumbnailer->get($model->picture['uri'], 100, 100, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) : '/img/avatars/1.png') ?>" alt="user profile picture" class="ui-w-100 rounded-circle">
                    <div class="media-body pt-2 ml-3">
                        <h5 class="mb-2"><?= User::getUserName($model->id) ?></h5>
                    </div>
                </div>
            </div>
            <hr class="border-light m-0">
            <div class="card-body">
                <?php
                $scanSession = \Yii::$app->security->generateRandomString();
                $_SESSION['tagScanSession'] = $scanSession;
                $_SESSION['tagScanPurpose'] = 'addTagID';
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
                <span class="float-right">
                    <a href="profile-settings" class="btn btn-secondary btn-sm"> <?=Yii::t('core_system', 'Back')?></a>
                </span>
            </div>
        </div>
    </div>
</div>
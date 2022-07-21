<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */
/* @var $model common\models\core\LoginForm */

use yii\helpers\Html;

$this->registerMetaTag([
    'name' => 'NEURON',
    'content' => Yii::$app->params['tagID_settings']['neuron']
]);
$this->registerJsFile("https://".Yii::$app->params['tagID_settings']['neuron']."/Events.js");
$this->registerJsFile("@web/js/QuickLogin.js");
$this->registerCssFile("@web/css/pages/QuickLogin.css");

$scanSession = \Yii::$app->security->generateRandomString();
$_SESSION['tagScanSession'] = $scanSession;
$_SESSION['tagScanPurpose'] = 'login';
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
<h4 class="text-center text-lighter font-weight-normal mt-5 mb-5"><?=Yii::t('core_system', 'Sign in to Your Account')?></h4>
<div id="quickLoginCode" data-serviceID="<?= $responseDecoded['serviceId'] ?>" data-mode="image" data-purpose="Identify yourself against <?= Yii::$app->params['default_site_settings']['site_name'] ?>" style="text-align: center;"></div>
<?php
if (Yii::$app->params['loginOptions']['allowEmail'] || Yii::$app->params['loginOptions']['allowPhone']) {
?>
    <div class="mt-3 text-center">
        <div class="signin-other-title">
            <h5 class="fs-13 mb-2 title"><?= Yii::t('core_system', 'Or sign in with') ?></h5>
        </div>
        <div>
            <?= (Yii::$app->params['loginOptions']['allowPhone'] ? '
                <a href="/site/login-mobile" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-phone-fill fs-16"></i></a>': '') ?>
            <?= (Yii::$app->params['loginOptions']['allowEmail'] ? '
                <a href="/site/loginemail" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-mail-fill fs-16"></i></a>': '') ?>
        </div>
    </div>
<?php
}
?>
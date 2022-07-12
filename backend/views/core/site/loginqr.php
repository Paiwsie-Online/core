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
    <div class="row">
        <div class="col-md-12 text-center mb-3 mt-4">
            <p class="text_white">
                <?php
                if (Yii::$app->params['loginOptions']['allowEmail'] && Yii::$app->params['loginOptions']['allowPhone']) {
                    echo Yii::t('core_system', 'Or you can login with Email or Phone.');
                } elseif (Yii::$app->params['loginOptions']['allowEmail']) {
                    echo Yii::t('core_system', 'Or you can login with Email.');
                } elseif (Yii::$app->params['loginOptions']['allowPhone']) {
                    echo Yii::t('core_system', 'Or you can login with Phone.');
                }
                ?>
            </p>
        </div>
        <div class="col-md-12 text-center">
            <?php
            if (Yii::$app->params['loginOptions']['allowEmail']) {
                echo Html::a(Yii::t('core_system', 'Email Login'), 'loginemail', ['class' => 'btn btn-primary mr-3']);
            }
            if (Yii::$app->params['loginOptions']['allowPhone']) {
                echo Html::a(Yii::t('core_system', 'Phone Login'), 'login-mobile', ['class' => 'btn btn-primary']);
            }
            ?>
        </div>
    </div>
<?php
}
?>
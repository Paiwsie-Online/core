<?php

namespace common\helpers\core;

use common\models\core\SystemLog;
use Yii;

class SmsHelper {

    /**
    $action: Action to know which is the message
    $actionParams: Array with Params
    $sentTo: Phone number that will be sent the message
    $provider: Api name used
    $userId: User Id that receive the message (can be null)
    */
    // ACTION SEND SMS
    public function sendSms($action, $actionParams, $sentTo, $provider = null) {
        // GET MESSAGE BY ACTION AND PARAMS
        $sms = $this->getMessage($action, $actionParams);
        if ($sms !== '') {
            // COMPONENT SEND SMS
            if ($provider === 'textLocal' || $provider === null) {
                Yii::$app->sms->sendSms($sentTo, $sms);
            }
            $systemLog = new SystemLog();
            $systemLog->saveSystemlog('Sent Sms', 'Via sms to: ' . $sentTo);
        }
    }


    // GET MESSAGE
    protected function getMessage($action, $actionParams = null) {
        $sms = '';
        if ($action === 'userRegister') {
            $sms = Yii::t('core_sms', '{smsCode} is your verification code to complete your registration. Thank you for registering to {site_name}.', ['smsCode' => $actionParams['smsCode'], 'site_name' => (Yii::$app->params['default_site_settings']['site_name'] ?? 'FinancePro')]);
        }
        if ($action === 'userForgotPass') {
            $sms = Yii::t('core_sms', '{smsCode} is your verification code to initiate a password reset. This code is only available for the next 2 hours.', ['smsCode' => $actionParams['smsCode']]);
        }
        /*
        if ($action === 'userChangePhone') {
            $sms = Yii::t('core_sms', '{smsCode} is your verification code to verify the change phone.', ['smsCode' => $actionParams['smsCode']]);
        }
        if ($action === 'userChangePhoneOld') {
            $sms = Yii::t('core_sms', 'You have initiated a change phone request.');
        }
        if ($action === 'userVerifiedChangePhone') {
            $sms = Yii::t('core_sms', 'Your Login Phone was changed successfully!');
        }
        if ($action === 'makeCharge') {
            $sms = Yii::t('core_sms', '{smsCode} is your verification code to finalize your purchase of {amount}', ['amount' => $actionParams['amount'], 'smsCode' => $actionParams['smsCode']]);
        }*/
        if ($action === 'userInvite') {
            $sms = Yii::t('core_sms', 'You have been invited to {organizationName}. Please Log in on the following link to accept the invitation. {link}', ['organizationName' => ($actionParams['organizationName'] ?? str_replace(' ','', Yii::$app->params['default_site_settings']['site_name'])), 'link' => Yii::$app->params['default_site_settings']['base_url']]);
        }
        return $sms;
    }

}
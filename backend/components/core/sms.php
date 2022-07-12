<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\components\core;

use common\models\core\OrganizationSetting;
use common\models\core\SystemLog;
use Yii;
use yii\base\Component;

class sms extends Component {

    public function sendSms($phoneNumbers, $message, $sender = null) {
        $numbers = (is_array($phoneNumbers) ? $phoneNumbers : array($phoneNumbers));
        $numbers = implode(',', $numbers);
        $senderName = null;
        if ($sender && is_int($sender)) {
            $smsSetting = OrganizationSetting::findOne(['organization_id' => $sender, 'setting' => 'smsSettings']);
            if ($smsSetting) {
                if (isset($smsSetting->value)) {
                    $setting = json_decode($smsSetting->value);
                    if (isset($setting->senderName)) {
                        $senderName = urlencode($setting->senderName);
                    }
                }
            }
        }
        if ($senderName === null) {
            $senderName = urlencode((Yii::$app->params['textLocal']['default_sms_sender_name'] ?? 'SmartAdmin'));
        }
        $messageSend = rawurlencode($message);
        $data = ['apiKey' => Yii::$app->params['textLocal']['apiKey'], 'numbers' => $numbers, 'sender' => $senderName, 'message' => $messageSend];
        // Send the POST request with cURL
        $ch = curl_init('http://api.txtlocal.com/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $systemLog = new SystemLog();
        $systemLog->message_short = 'SMS message sent';
        $systemLog->message = 'SMS message sent to '.$numbers;
        $systemLog->data_format = json_encode($response);
        $systemLog->save();
        return true;
    }

}
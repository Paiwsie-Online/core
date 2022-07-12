<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\base\Model;

class ContactForm extends Model {
    public $name;
    public $email;
    public $subject;
    public $body;

    public function rules() {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => Yii::t('core_model', 'Name') . '*',
            'email' => Yii::t('core_model', 'Email') . '*',
            'verifyCode' => Yii::t('core_model', 'Verification Code'),
            'subject' => Yii::t('core_model', 'Subject') . '*',
            'body' => Yii::t('core_model', 'Body') . '*',
        ];
    }

    public function contact($email) {
        /*if ($this->validate()) {*/
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        /*}
        return false;*/
    }

}
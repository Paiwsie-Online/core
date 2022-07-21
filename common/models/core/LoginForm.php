<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\base\Model;
use yii\web\Cookie;

class LoginForm extends Model {

    public $email;
    public $password;
    public $rememberMe = true;
    private $_user = false;
    public $phone;
    public $password2;

    public function rules() {
        return [
            ['email', 'required', 'on' => ['login']],
            ['password', 'required', 'on' => ['login']],
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean'],
            ['phone', 'required', 'on' => ['loginMobile']],
            ['password2', 'required', 'on' => ['loginMobile']],
            ['password2', 'validatePassword2'],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['login'] = ['email', 'password'];
        $scenarios['loginMobile'] = ['phone', 'password2'];
        return $scenarios;
    }

    public function attributeLabels() {
        return [
            'phone' => Yii::t('core_model', 'Phone') . '*',
            'email' => Yii::t('core_model', 'Email') . '*',
            'password' => Yii::t('core_model', 'Password') . '*',
            'password2' => Yii::t('core_model', 'Password') . '*',
        ];
    }

    // ACTION LOGIN EMAIL
    public function login() {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), Yii::$app->params['systemTimeout']['authTimeout'])) {
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' logged in';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' logged in using Email: ' . ($model->email ?? 'Error!') . ' for this instance ' . Yii::$app->user->identity->instance . ' from ip: ' . Yii::$app->request->getUserIP();
                $dataFormat = [
                    'event' => 'login',
                    'user' => Yii::$app->user->identity->id,
                    'method' => 'email',
                    'ip' => Yii::$app->request->getUserIP(),
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
                $userLogin = new UserLogin();
                $userLogin->user_id = Yii::$app->user->identity->id;
                $userLogin->ip = Yii::$app->request->getUserIP();
                $timeNow = new \DateTime('now', new \DateTimeZone(Yii::$app->params['defaults']['systemTimeZone']));
                $timeNowUTC = $timeNow->getTimestamp();
                $userLogin->expire = $timeNowUTC + Yii::$app->params['systemTimeout']['authTimeout'];
                $userLogin->session_id = Yii::$app->session->id;
                $userLogin->save();
                if (isset(Yii::$app->request->cookies['userSession'])) {
                    $cookies = Yii::$app->response->cookies;
                    unset($cookies['userSession']);
                }
                $userSessionCookie = new Cookie([
                    'name' => 'userSession',
                    'value' => '1',
                    'httpOnly' => false,
                ]);
                Yii::$app->response->cookies->add($userSessionCookie);
                Yii::$app->cache->flush();
                return true;
            }
        }
        return false;
    }

    // GET USER BY EMAIL
    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email, \Yii::$app->params['default_site_settings']['instance']);
        }
        return $this->_user;
    }

    // VALIDATE PASSWORD FOR EMAIL
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    // ACTION LOGIN PHONE
    public function loginMobile() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUserMobile(), Yii::$app->params['systemTimeout']['authTimeout']);
        }
        return false;
    }

    // GET USER BY PHONE
    public function getUserMobile() {
        $this->_user = User::findOne(['phone' => $this->phone, 'instance' => Yii::$app->params['default_site_settings']['instance']]);
        return $this->_user;
    }

    // VALIDATE PASSWORD FOR PHONE
    public function validatePassword2($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUserMobile();
            if (!$user || !$user->validatePassword($this->password2)) {
                $this->addError($attribute, 'Incorrect phone or password.');
            }
        }
    }

    // ACTION CLIENT LINK REDIRECT LOGIN PHONE
    public function redirectLoginMobile($userCid) {
        $user = User::findOne(['cid' => $userCid]);
        if (isset($user)) {
            return Yii::$app->user->login($user, Yii::$app->params['systemTimeout']['authTimeout']);
        }
        return false;
    }

}
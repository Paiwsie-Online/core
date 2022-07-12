<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $ip
 * @property string $logged
 * @property integer|null $expire
 * @property string $status
 * @property string $session_id
 * @property integer $session_logged
 * @property User $user
 */

class UserLogin extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'user_login';
    }

    public function rules() {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['logged'], 'safe'],
            [['expire'], 'integer'],
            [['session_logged'], 'integer'],
            [['session_id'], 'string', 'max' => 64],
            [['ip'], 'string', 'max' => 64],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'user_id' => Yii::t('core_model', 'User ID') . '*',
            'ip' => Yii::t('core_model', 'Ip'),
            'logged' => Yii::t('core_model', 'Logged'),
            'expire' => Yii::t('core_model', 'Expire'),
            'session_id' => Yii::t('core_model', 'Session ID'),
            'session_logged' => Yii::t('core_model', 'Session Logged'),
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
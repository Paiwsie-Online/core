<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property int $loginID
 * @property string $sessionID
 * @property int $uID
 * @property string $sessionTime

 * @property User $u
 */

class UserSession extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'user_session';
    }

    public function rules() {
        return [
            [['sessionID', 'uID'], 'required'],
            [['uID'], 'integer'],
            [['sessionTime'], 'safe'],
            [['sessionID'], 'string', 'max' => 255],
            [['uID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uID' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'loginID' => Yii::t('core_model', 'Login ID'),
            'sessionID' => Yii::t('core_model', 'Session ID') . '*',
            'uID' => Yii::t('core_model', 'User ID') . '*',
            'sessionTime' => Yii::t('core_model', 'Session Time'),
        ];
    }

    public function getU() {
        return $this->hasOne(User::className(), ['id' => 'uID']);
    }

}
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property int $user_id
 * @property string $setting
 * @property string|null $value

 * @property User $user
 */

class UserSetting extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'user_setting';
    }

    public static function findSetting($user_id, string $setting, bool $returnValue = false) {
        $setting = self::findOne(['user_id' => $user_id, 'setting' => $setting]);
        if ($setting) {
            if ($returnValue) {
                return $setting->value;
            }
            return $setting;
        }
        return false;
    }

    public function rules() {
        return [
            [['user_id', 'setting'], 'required'],
            [['user_id'], 'integer'],
            [['value'], 'string'],
            [['setting'], 'string', 'max' => 128],
            [['user_id', 'setting'], 'unique', 'targetAttribute' => ['user_id', 'setting']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'user_id' => Yii::t('core_model', 'User ID') . '*',
            'setting' => Yii::t('core_model', 'Setting') . '*',
            'value' => Yii::t('core_model', 'Value'),
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
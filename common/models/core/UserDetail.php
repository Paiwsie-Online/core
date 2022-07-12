<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property int $user_id
 * @property string $detail
 * @property string|null $value

 * @property User $user
 */

class UserDetail extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'user_detail';
    }

    public static function findDetail($user_id, string $detail, bool $returnValue = false) {
        $detail = self::findOne(['user_id' => $user_id, 'detail' => $detail]);
        if ($detail) {
            if ($returnValue) {
                return $detail->value;
            }
            return $detail;
        }
        return false;
    }

    public function rules() {
        return [
            [['user_id', 'detail'], 'required'],
            [['user_id'], 'integer'],
            [['value'], 'string'],
            [['detail'], 'string', 'max' => 128],
            [['user_id', 'detail'], 'unique', 'targetAttribute' => ['user_id', 'detail']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'user_id' => Yii::t('core_model', 'User ID') . '*',
            'detail' => Yii::t('core_model', 'Detail') . '*',
            'value' => Yii::t('core_model', 'Value'),
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property string $language_id
 * @property string $language
 * @property string $country
 * @property string $name
 * @property string $name_ascii
 * @property int $status
**/

class Language extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'language';
    }

    public function rules() {
        return [
            [['language_id', 'language', 'country', 'name', 'name_ascii', 'status'], 'required'],
            [['status'], 'integer'],
            [['language_id'], 'string', 'max' => 5],
            [['language', 'country'], 'string', 'max' => 3],
            [['name', 'name_ascii'], 'string', 'max' => 32],
            [['language_id'], 'unique'],
        ];
    }

    public function attributeLabels() {
        return [
            'language_id' => Yii::t('core_model', 'ID') . '*',
            'language' => Yii::t('core_model', 'Language') . '*',
            'country' => Yii::t('core_model', 'Country') . '*',
            'name' => Yii::t('core_model', 'Name') . '*',
            'name_ascii' => Yii::t('core_model', 'Name Ascii') . '*',
            'status' => Yii::t('core_model', 'Status') . '*',
        ];
    }

    public static function getLanguages() {
        return self::find()->indexBy('language_id')->where(['status' => [1, 2]])->all();
    }

    public static function getPreferredLanguages() {
        $temp_list = self::find()->indexBy('language_id')->where(['status' => [1, 2]])->all();
        return ArrayHelper::map($temp_list, 'language_id', 'language_id');
    }

}
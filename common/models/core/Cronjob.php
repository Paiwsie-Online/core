<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $url
 *
 * @property CronjobLog[] $cronjobLogs
 */

class Cronjob extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'cronjob';
    }

    public function rules() {
        return [
            [['name', 'description', 'url'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['url'], 'string', 'max' => 512],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'name' => Yii::t('core_model', 'Name'),
            'description' => Yii::t('core_model', 'Description'),
            'url' => Yii::t('core_model', 'Url'),
        ];
    }

    public function getCronjobLogs() {
        return $this->hasMany(CronjobLog::className(), ['cronjob_id' => 'id']);
    }

}
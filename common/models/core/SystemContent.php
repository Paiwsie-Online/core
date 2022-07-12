<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property string $content
 * @property string $instance
 * @property string $value
 */

class SystemContent extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'system_content';
    }

    public function rules() {
        return [
            [['content', 'value'], 'required'],
            [['value'], 'string'],
            [['content', 'instance'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels() {
        return [
            'content' => Yii::t('core_model', 'Content') . '*',
            'value' => Yii::t('core_model', 'Value') . '*',
            'instance' => Yii::t('core_model', 'Instance'),
        ];
    }

    public static function getContent($content) {
        $preferredContent = self::find()->where(['instance' => Yii::$app->params['default_site_settings']['instance'], 'content' => $content])->one();
        if ($preferredContent) {
            return $preferredContent->value;
        }
        $defaultContent = self::find()->where(['instance' => 'default', 'content' => $content])->one();
        if ($defaultContent) {
            return $defaultContent->value;
        }
        return Yii::t('core_system', 'Not Found');
    }

}
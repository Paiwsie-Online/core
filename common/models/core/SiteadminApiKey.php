<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property int $id
 * @property int $key_id
 * @property string $module_id
 * @property int $right_create
 * @property int $right_read
 * @property int $right_update
 * @property int $right_delete
 * @property string $rights_given
 * @property int|null $rights_given_by
 *
 * @property ApiKey $key
 * @property Module $module
 * @property User $rightsGivenBy
 */

class SiteadminApiKey extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'siteadmin_api_key';
    }

    public function rules() {
        return [
            [['key_id', 'module_id', 'right_create', 'right_read', 'right_update', 'right_delete'], 'required'],
            [['key_id', 'right_create', 'right_read', 'right_update', 'right_delete', 'rights_given_by'], 'integer'],
            [['rights_given'], 'safe'],
            [['module_id'], 'string', 'max' => 50],
            [['key_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiKey::className(), 'targetAttribute' => ['key_id' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['rights_given_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['rights_given_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'key_id' => Yii::t('core_model', 'Key ID') . '*',
            'module_id' => Yii::t('core_model', 'Module ID') . '*',
            'right_create' => Yii::t('core_model', 'Right Create') . '*',
            'right_read' => Yii::t('core_model', 'Right Read') . '*',
            'right_update' => Yii::t('core_model', 'Right Update') . '*',
            'right_delete' => Yii::t('core_model', 'Right Delete') . '*',
            'rights_given' => Yii::t('core_model', 'Rights Given'),
            'rights_given_by' => Yii::t('core_model', 'Rights Given By'),
        ];
    }

    public function getKey() {
        return $this->hasOne(ApiKey::className(), ['id' => 'key_id']);
    }

    public function getModule() {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }

    public function getRightsGivenBy() {
        return $this->hasOne(User::className(), ['id' => 'rights_given_by']);
    }

}
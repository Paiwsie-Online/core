<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**

 * @property int $id
 * @property int $ou_relation_id
 * @property int $cmr_id
 * @property int $right_create
 * @property int $right_read
 * @property int $right_update
 * @property int $right_delete
 * @property string $rights_given
 * @property int|null $rights_given_by

 * @property OrganizationUserRelation $cuRelation
 * @property OrganizationModuleRelation $module
 * @property User $rightsGivenBy
 */

class OrganizationUserModuleRight extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'organization_user_module_right';
    }

    public function rules() {
        return [
            [['ou_relation_id', 'cmr_id'], 'required'],
            [['ou_relation_id', 'right_create', 'right_read', 'right_update', 'right_delete', 'rights_given_by', 'cmr_id'], 'integer'],
            [['rights_given'], 'safe'],
            [['ou_relation_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationUserRelation::className(), 'targetAttribute' => ['ou_relation_id' => 'id']],
            [['cmr_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationModuleRelation::className(), 'targetAttribute' => ['cmr_id' => 'id']],
            [['rights_given_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['rights_given_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'ou_relation_id' => Yii::t('core_model', 'Cu Relation ID') . '*',
            'cmr_id' => Yii::t('core_model', 'CMR ID') . '*',
            'right_create' => Yii::t('core_model', 'Right Create'),
            'right_read' => Yii::t('core_model', 'Right Read'),
            'right_update' => Yii::t('core_model', 'Right Update'),
            'right_delete' => Yii::t('core_model', 'Right Delete'),
            'rights_given' => Yii::t('core_model', 'Rights Given'),
            'rights_given_by' => Yii::t('core_model', 'Rights Given By'),
        ];
    }

    public function getCuRelation() {
        return $this->hasOne(OrganizationUserRelation::className(), ['id' => 'ou_relation_id']);
    }

    public function getModule() {
        return $this->hasOne(OrganizationModuleRelation::className(), ['id' => 'cmr_id']);
    }

    public function getRightsGivenBy() {
        return $this->hasOne(User::className(), ['id' => 'rights_given_by']);
    }

}
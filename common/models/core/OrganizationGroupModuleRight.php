<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**

 * @property int $id
 * @property int $group_id
 * @property int $cmr_id
 * @property int $right_create
 * @property int $right_read
 * @property int $right_update
 * @property int $right_delete
 * @property string $rights_given
 * @property int|null $rights_given_by

 * @property OrganizationUsergroup $group
 * @property OrganizationModuleRelation $module
 * @property User $rightsGivenBy
 */

class OrganizationGroupModuleRight extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'organization_group_module_right';
    }

    public function rules() {
        return [
            [['group_id', 'cmr_id'], 'required'],
            [['group_id', 'right_create', 'right_read', 'right_update', 'right_delete', 'rights_given_by', 'cmr_id'], 'integer'],
            [['rights_given'], 'safe'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationUsergroup::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['cmr_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationModuleRelation::className(), 'targetAttribute' => ['cmr_id' => 'id']],
            [['rights_given_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['rights_given_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'group_id' => Yii::t('core_model', 'Group ID') . '*',
            'cmr_id' => Yii::t('core_model', 'CMR ID') . '*',
            'right_create' => Yii::t('core_model', 'Right Create'),
            'right_read' => Yii::t('core_model', 'Right Read'),
            'right_update' => Yii::t('core_model', 'Right Update'),
            'right_delete' => Yii::t('core_model', 'Right Delete'),
            'rights_given' => Yii::t('core_model', 'Rights Given'),
            'rights_given_by' => Yii::t('core_model', 'Rights Given By'),
        ];
    }

    public function getGroup() {
        return $this->hasOne(OrganizationUsergroup::className(), ['id' => 'group_id']);
    }

    public function getModule() {
        return $this->hasOne(OrganizationModuleRelation::className(), ['id' => 'cmr_id']);
    }

    public function getRightsGivenBy() {
        return $this->hasOne(User::className(), ['id' => 'rights_given_by']);
    }

}
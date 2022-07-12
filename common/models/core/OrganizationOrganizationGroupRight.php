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
 * @property int $cc_relation_id
 * @property int $right_create
 * @property int $right_read
 * @property int $right_update
 * @property int $right_delete
 * @property string $rights_given
 * @property int|null $rights_given_by

 * @property OrganizationOrganizationRelation $ccRelation
 * @property OrganizationUsergroup $group
 * @property User $rightsGivenBy
 */

class OrganizationOrganizationGroupRight extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'organization_organization_group_right';
    }

    public function rules() {
        return [
            [['group_id', 'cc_relation_id'], 'required'],
            [['group_id', 'cc_relation_id', 'right_create', 'right_read', 'right_update', 'right_delete', 'rights_given_by'], 'integer'],
            [['rights_given'], 'safe'],
            [['cc_relation_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationOrganizationRelation::className(), 'targetAttribute' => ['cc_relation_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationUsergroup::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['rights_given_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['rights_given_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'group_id' => Yii::t('core_model', 'Group ID') . '*',
            'cc_relation_id' => Yii::t('core_model', 'Cc Relation ID') . '*',
            'right_create' => Yii::t('core_model', 'Right Create'),
            'right_read' => Yii::t('core_model', 'Right Read'),
            'right_update' => Yii::t('core_model', 'Right Update'),
            'right_delete' => Yii::t('core_model', 'Right Delete'),
            'rights_given' => Yii::t('core_model', 'Rights Given'),
            'rights_given_by' => Yii::t('core_model', 'Rights Given By'),
        ];
    }

    public function getCcRelation() {
        return $this->hasOne(OrganizationOrganizationRelation::className(), ['id' => 'cc_relation_id']);
    }

    public function getGroup() {
        return $this->hasOne(OrganizationUsergroup::className(), ['id' => 'group_id']);
    }

    public function getRightsGivenBy() {
        return $this->hasOne(User::className(), ['id' => 'rights_given_by']);
    }

}
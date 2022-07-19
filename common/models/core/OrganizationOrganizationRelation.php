<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $parent_organization
 * @property int $child_organization
 * @property int|null $created_by
 * @property int $created
 * @property OrganizationOrganizationGroupRight[] $organizationOrganizationGroupRights
 * @property Organization $parentOrganization
 * @property Organization $childOrganization
 * @property User $addedBy
 * @property OrganizationOrganizationUserRight[] $organizationOrganizationUserRights
 */

class OrganizationOrganizationRelation extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'organization_organization_relation';
    }

    public function behaviors() {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class,
        ];
    }

    public function rules() {
        return [
            [['parent_organization', 'child_organization'], 'required'],
            [['parent_organization', 'child_organization', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['parent_organization'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['parent_organization' => 'id']],
            [['child_organization'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['child_organization' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'parent_organization' => Yii::t('core_model', 'Parent Organization') . '*',
            'child_organization' => Yii::t('core_model', 'Child Organization') . '*',
            'created_by' => Yii::t('core_model', 'Added By'),
            'created_at' => Yii::t('core_model', 'Added Time'),
        ];
    }

    public function getOrganizationOrganizationGroupRights() {
        return $this->hasMany(OrganizationOrganizationGroupRight::className(), ['cc_relation_id' => 'id']);
    }

    public function getParentOrganization() {
        return $this->hasOne(Organization::className(), ['id' => 'parent_organization']);
    }

    public function getChildOrganization() {
        return $this->hasOne(Organization::className(), ['id' => 'child_organization']);
    }

    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getOrganizationOrganizationUserRights() {
        return $this->hasMany(OrganizationOrganizationUserRight::className(), ['cc_relation_id' => 'id']);
    }

}
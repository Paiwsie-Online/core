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
 * @property int|null $added_by
 * @property string $added_time
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
            [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['added_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['added_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
        ];
    }

    public function rules() {
        return [
            [['parent_organization', 'child_organization'], 'required'],
            [['parent_organization', 'child_organization', 'added_by'], 'integer'],
            [['added_time'], 'safe'],
            [['parent_organization'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['parent_organization' => 'id']],
            [['child_organization'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['child_organization' => 'id']],
            [['added_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['added_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'parent_organization' => Yii::t('core_model', 'Parent Organization') . '*',
            'child_organization' => Yii::t('core_model', 'Child Organization') . '*',
            'added_by' => Yii::t('core_model', 'Added By'),
            'added_time' => Yii::t('core_model', 'Added Time'),
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

    public function getAddedBy() {
        return $this->hasOne(User::className(), ['id' => 'added_by']);
    }

    public function getOrganizationOrganizationUserRights() {
        return $this->hasMany(OrganizationOrganizationUserRight::className(), ['cc_relation_id' => 'id']);
    }

}
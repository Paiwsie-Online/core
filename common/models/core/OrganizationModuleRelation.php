<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property int $id
 * @property int $organization_id
 * @property string $module_id
 * @property OrganizationGroupModuleRight[] $organizationGroupModuleRights
 * @property Organization $organization
 * @property Module $module
 * @property OrganizationUserModuleRight[] $organizationUserModuleRights
 */

class OrganizationModuleRelation extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'organization_module_relation';
    }


    public function rules() {
        return [
            [['organization_id', 'module_id'], 'required'],
            [['id', 'organization_id'], 'integer'],
            [['organization_id', 'module_id'], 'unique', 'targetAttribute' => ['organization_id', 'module_id']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'organization_id' => Yii::t('core_model', 'Organization ID') . '*',
            'module_id' => Yii::t('core_model', 'Module ID') . '*',
        ];
    }

    public function getOrganizationGroupModuleRights() {
        return $this->hasMany(OrganizationGroupModuleRight::className(), ['cmr_id' => 'id']);
    }

    public function getOrganization() {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    public function getModule() {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }

    public function getOrganizationUserModuleRights() {
        return $this->hasMany(OrganizationUserModuleRight::className(), ['cmr_id' => 'id']);
    }

}
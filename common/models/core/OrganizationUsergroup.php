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
 * @property int $organization_id
 * @property string $name
 * @property int|null $created_by
 * @property int $created_at
 * @property OrganizationOrganizationGroupRight[] $organizationOrganizationGroupRights
 * @property OrganizationGroupModuleRight[] $organizationGroupModuleRights
 * @property Organization $organization
 * @property User $createdBy
 * @property OrganizationUsergroupUserRelation[] $organizationUsergroupUserRelations
 */

class OrganizationUsergroup extends \yii\db\ActiveRecord {

    public $created_by_full_name;

    public static function tableName() {
        return 'organization_usergroup';
    }

    public function behaviors() {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class,
        ];
    }
    public function rules() {
        return [
            [['name'], 'required'],
            [['organization_id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'organization_id' => Yii::t('core_model', 'Organization'),
            'name' => Yii::t('core_model', 'Name') . '*',
            'created_by' => Yii::t('core_model', 'Created By'),
            'created_at' => Yii::t('core_model', 'Creation date'),
            'created_by_full_name'  =>  Yii::t('core_model', 'Created By'),
        ];
    }

    public function getOrganizationOrganizationGroupRights() {
        return $this->hasMany(OrganizationOrganizationGroupRight::className(), ['group_id' => 'id']);
    }

    public function getOrganizationGroupModuleRights() {
        return $this->hasMany(OrganizationGroupModuleRight::className(), ['group_id' => 'id']);
    }

    public function getOrganization() {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getOrganizationUsergroupUserRelations() {
        return $this->hasMany(OrganizationUsergroupUserRelation::className(), ['group_id' => 'id']);
    }

    public function hasAccess($module, $right, $group_id, $organization_id = null) {
        if ($organization_id === null) {
            $organization_id = Yii::$app->user->identity->selectedOrganization->id;
        }
        $accessRight = 'right_'.$right;
        $module = Module::find()->where(['id' => $module])->one();
        if ($module) {
            $organizationModuleRelation = OrganizationModuleRelation::find()->where(['organization_id' =>  $organization_id, 'module_id' => $module->id])->one();
            if ($organizationModuleRelation) {
                $organizationGroupModuleRights = OrganizationGroupModuleRight::find()->where(['group_id' => $group_id, 'cmr_id' => $organizationModuleRelation->id])->one();
                if (isset($organizationGroupModuleRights->{$accessRight}) && $organizationGroupModuleRights->{$accessRight} === 1) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function getCreatedByUser() {
        $temp_list = self::find()->indexBy('created_by')->all();
        $users = [];
        foreach ($temp_list as $item) {
            $user = User::findIdentity($item->created_by);
            if ($user) {
                $users[$user->id] = $user->first_name . ' ' . $user->last_name;
            }
        }
        return $users;
    }

}
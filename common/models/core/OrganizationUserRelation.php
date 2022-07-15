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
 * @property int|null $user_id
 * @property string|null $title
 * @property int|null $added_by
 * @property string $user_level
 * @property string $added
 * @property string $status
 * @property string|null $status_changed
 * @property int|null $selected_organization
 * @property OrganizationOrganizationUserRight[] $organizationOrganizationUserRights
 * @property OrganizationUserModuleRight[] $organizationUserModuleRights
 * @property Organization $organization
 * @property User $user
 * @property User $addedBy
 * @property OrganizationUsergroupUserRelation[] $organizationUsergroupUserRelations
 */

class OrganizationUserRelation extends \yii\db\ActiveRecord {

    public $user_full_name;
    public $added_by_full_name;
    public $sent_to_email;
    public $sent_to_mobile;

    public static function tableName() {
        return 'organization_user_relation';
    }

    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'added_by',
                'updatedByAttribute' => false,
            ],
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'added',
                'updatedAtAttribute' => false,
            ],
        ];
    }
    public function rules() {
        return [
            [['organization_id', 'user_level', 'title'], 'required'],
            [['organization_id', 'user_id', 'added_by'], 'integer'],
            [['user_level', 'status'], 'string'],
            [['added', 'status_changed'], 'safe'],
            [['title'], 'string', 'max' => 128],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'exist', 'skipOnEmpty'  => true, 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['added_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['added_by' => 'id']],
            [['selected_organization'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'organization_id' => Yii::t('core_model', 'Organization ID') . '*',
            'user_id' => Yii::t('core_model', 'User'),
            'title' => Yii::t('core_model', 'Title'),
            'added_by' => Yii::t('core_model', 'Added By'),
            'user_level' => Yii::t('core_model', 'User Level') . '*',
            'added' => Yii::t('core_model', 'Added Time'),
            'status' => Yii::t('core_model', 'Status'),
            'status_changed' => Yii::t('core_model', 'Status Changed'),
            'user_full_name'  =>  Yii::t('core_model', 'Name'),
            'added_by_full_name'  =>  Yii::t('core_model', 'Added By'),
        ];
    }

    public function getOrganizationOrganizationUserRights() {
        return $this->hasMany(OrganizationOrganizationUserRight::className(), ['user_id' => 'id']);
    }

    public function getOrganizationUserModuleRights() {
        return $this->hasMany(OrganizationUserModuleRight::className(), ['ou_relation_id' => 'id']);
    }

    public function getOrganization() {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getAddedBy() {
        return $this->hasOne(User::className(), ['id' => 'added_by']);
    }

    public function getOrganizationUsergroupUserRelations() {
        return $this->hasMany(OrganizationUsergroupUserRelation::className(), ['ou_relation_id' => 'id']);
    }

    public static function setSelectedOrganization($organization_id, $user_id = null) {
        if (!$user_id) {
            $user_id = Yii::$app->user->identity->id;
        }
        $organizations = self::find()->indexBy('id')->where(['user_id' => $user_id])->all();
        foreach ($organizations as $organization) {
            $organization->selected_organization = 0;
            $organization->save();
        }
        $organization = self::find()->indexBy('id')->where(['organization_id' => $organization_id, 'user_id' => $user_id])->one();
        if ($organization) {
            $organization->selected_organization = 1;
            $organization->save();
        }
        return true;
    }

    public static function getSelectedOrganization($user_id = null) {
        if (!$user_id) {
            $user_id = Yii::$app->user->identity->id;
        }
        return self::find()->indexBy('id')->where(['user_id' => $user_id, 'selected_organization' => 1])->one();
    }

    public static function getUsername() {
        $temp_list = self::find()->indexBy('user_id')->where(['organization_id' => Yii::$app->user->identity->selectedOrganization['id']])->all();
        $users = [];
        foreach ($temp_list as $item) {
            $user = User::findIdentity($item->user_id);
            if ($user) {
                $users[$user->id] = $user->first_name . ' ' . $user->last_name;
            }
        }
        return $users;
    }

    public static function getAddedByUser() {
        $temp_list = self::find()->indexBy('added_by')->where(['organization_id' => Yii::$app->user->identity->selectedOrganization['id']])->all();
        $users = [];
        foreach ($temp_list as $item) {
            $user = User::findIdentity($item->added_by);
            if ($user) {
                $users[$user->id] = $user->first_name . ' ' . $user->last_name;
            }
        }
        return $users;
    }

    public static function getUserLevelOptions() {
        $enumUserLevel = OrganizationUserRelation::getTableSchema()->columns['user_level']->enumValues;
        $userLevelList = [];
        foreach ($enumUserLevel as $enum) {
            $userLevelList += [
                $enum => ucfirst(Yii::t('language_force_translation', $enum)),
            ];
        }
        return $userLevelList;
    }

    public static function getStatusOptions() {
        $enumStatus = OrganizationUserRelation::getTableSchema()->columns['status']->enumValues;
        $userStatusList = [];
        foreach ($enumStatus as $enum) {
            $userStatusList += [
                $enum => ucfirst(Yii::t('language_force_translation', $enum)),
            ];
        }
        return $userStatusList;
    }

}
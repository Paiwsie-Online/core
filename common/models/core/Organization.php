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
use yii\helpers\ArrayHelper;

/**
 * @property int $id
 * @property string $name
 * @property string $legal_name
 * @property int|null $created_by
 * @property int $created_at
 * @property string $instance
 * @property string $kyc
 * @property string $kyc_status_changed
 * @property string $model

 * @property User $createdBy
 * @property OrganizationOrganizationRelation[] $organizationOrganizationRelations
 * @property OrganizationOrganizationRelation[] $organizationOrganizationRelations0
 * @property OrganizationModuleRelation[] $organizationModuleRelations
 * @property Module[] $modules
 * @property OrganizationDetail[] $details
 * @property OrganizationUserRelation[] $organizationUserRelations
 * @property OrganizationUsergroup[] $organizationUsergroups
 * @property SystemLog[] $systemLogs
 */

class Organization extends \yii\db\ActiveRecord {

    public $created_by_full_name;

    public static function tableName() {
        return 'organization';
    }

    public function rules() {
        return [
            [['name'], 'required'],
            [['created_by'], 'integer'],
            [['name'], 'string', 'max' => 256],
            [['model'], 'string', 'max' => 512],
            [['instance'], 'string', 'max' => 126],
            [['tax_number'], 'string', 'max' => 64],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['created_at', 'kyc', 'kyc_status_changed', 'legal_name'], 'safe'],
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ],
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'name' => Yii::t('core_model', 'Name') . '*',
            'legal_name' => Yii::t('core_model', 'Legal Name'),
            'tax_number' => Yii::t('core_model', 'Tax Number'),
            'created_by' => Yii::t('core_model', 'Created By'),
            'created_at' => Yii::t('core_model', 'Created Time'),
            'instance'  =>  Yii::t('core_model', 'Instance'),
            'created_by_full_name'  =>  Yii::t('core_model', 'Created By'),
            'kyc'   =>  Yii::t('core_model', 'kyc'),
            'kyc_status_changed' => Yii::t('core_model', 'kyc status changed'),
            'model' => Yii::t('core_model', 'model'),
        ];
    }

    // GET USER MODEL
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    // GET ORGANIZATION ORGANIZATION RELATIONS MODEL
    public function getOrganizationOrganizationRelations() {
        return $this->hasMany(OrganizationOrganizationRelation::className(), ['parent_organization' => 'id']);
    }

    // GET ORGANIZATION ORGANIZATION RELATIONS MODEL
    public function getOrganizationOrganizationRelations0() {
        return $this->hasMany(OrganizationOrganizationRelation::className(), ['child_organization' => 'id']);
    }

    // GET ORGANIZATION MODULE RELATIONS MODEL
    public function getOrganizationModuleRelations() {
        return $this->hasMany(OrganizationModuleRelation::className(), ['organization_id' => 'id']);
    }

    // GET MODULE MODEL
    public function getModules() {
        return $this->hasMany(Module::className(), ['id' => 'module_id'])->viaTable('organization_module_relation', ['organization_id' => 'id']);
    }

    // GET ORGANIZATION DETAILS
    public function getDetails() {
        return $this->hasMany(OrganizationDetail::className(), ['organization_id' => 'id']);
    }

    // GET ORGANIZATION USER RELATIONS MODEL
    public function getOrganizationUserRelations() {
        return $this->hasMany(OrganizationUserRelation::className(), ['organization_id' => 'id']);
    }

    // GET ORGANIZATION USER GROUPS MODEL
    public function getOrganizationUsergroups() {
        return $this->hasMany(OrganizationUsergroup::className(), ['organization_id' => 'id']);
    }

    // GET SYSTEM LOG MODEL
    public function getSystemLogs() {
        return $this->hasMany(SystemLog::className(), ['organization_id' => 'id']);
    }

    // GET ACCOUNT MODEL
/*    public function getAccounts() {
        return $this->hasMany(Account::className(), ['organization_id' => 'id'])->where(['type' => (isset($_SESSION['testMode']) && $_SESSION['testMode'] === true ? 'test' : 'live')]);
    }*/

    // RETURN ARRAY OF ALL USERS FOR ORGANIZATION
    public function getUserList() {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('organization_user_relation', ['organization_id' => 'id'], function($query){
            $query->andWhere(['status' => 'accepted']);
        })->asArray()->all();
    }

    // RETURN ARRAY WITH USERS OF A ORGANIZATION FOR DROPDOWN
    public function getUserListAddUserListRelation($id = null) {
        if ($id === null) {
            $id = Yii::$app->user->identity->selectedOrganization['id'];
        }
        $temp_list = OrganizationUserRelation::find()->joinWith('user')->where(['organization_id' => $id, 'organization_user_relation.status' => 'accepted'])->all();
        $temp_array = ArrayHelper::map($temp_list, 'id', 'user.id');
        foreach ($temp_array as $key => $value) {
            $temp_array[$key] = User::getUserName($value);
        }
        return $temp_array;
    }

    // RETURN ARRAY WITH USERS OF A ORGANIZATION DISABLED FOR DROPDOWN
    public function getUserListAddUserListRelationDisabled($group_id) {
        $organizationUserGroupRelations = OrganizationUsergroupUserRelation::find()->where(['group_id' => $group_id])->all();
        $disabledArray = [];
        foreach ($organizationUserGroupRelations as $cugr) {
            $disabledArray[$cugr->ou_relation_id] = ['disabled' => true];
        }
        return $disabledArray;
    }

    // RETURN ARRAY WITH GROUPS OF A ORGANIZATION USER RELATION
    public function getGroupListUserRelation($ou_relation_id) {
        return OrganizationUsergroup::find()->joinWith('organizationUsergroupUserRelations')->where(['ou_relation_id' => $ou_relation_id])->all();
    }

    // RETURN ARRAY WITH GROUPS OF A ORGANIZATION FOR DROPDOWN
    public static function getGroupsByOrganization($organization_id) {
        $groups = OrganizationUsergroup::find()->where(['organization_id' => $organization_id])->all();
        $temp_array = [];
        foreach ($groups as $group) {
            $temp_array[$group->id] = $group->name;
        }
        return $temp_array;
    }

    // RETURN ARRAY WITH GROUPS OF A ORGANIZATION DISABLED FOR DROPDOWN
    public static function getGroupsByOrganizationDisabled($ou_relation_id) {
        $groups = OrganizationUsergroupUserRelation::find()->where(['ou_relation_id' => $ou_relation_id])->all();
        $disabledArray = [];
        foreach ($groups as $group) {
            $disabledArray[$group->group_id] = ['disabled' => true];
        }
        return $disabledArray;
    }

    // RETURN ARRAY WITH ALL INSTANCES
    public static function getInstances() {
        $temp_list = self::find()->indexBy('instance')->all();
        return ArrayHelper::map($temp_list, 'instance', 'instance');
    }

    // RETURN ORGANIZATION NAME
    public static function getOrganizationName($id = null) {
        if ($id === null) {
            $id = 0;
        }
        $organization = self::find()->where(['id' => $id])->one();
        if ($id === 0) {
            return Yii::t('core_system', 'Not Set');
        } else {
            return ($organization->name ?? '');
        }
    }

    // RETURN TRUE OR FALSE IF KYC IS APPROVED
    public static function getKycdone($id = null) {
        if ($id === null) {
            $id = Yii::$app->user->identity->selectedOrganization['id'];
        }
        if ($id) {
            $organization = self::findOne($id);
            if ($organization) {
                if ($organization->kyc === 'approved') {
                    return true;
                }
            }
        }
        return false;
    }

    // GET STATUS FOR DROPDOWN (TRANSLATIONS)
    public static function getStatus() {
        return [
            'none' => Yii::t('organization', 'None'),
            'inProgress' => Yii::t('organization', 'In progress'),
            'pending' => Yii::t('organization', 'Pending'),
            'approved' => Yii::t('organization', 'Approved'),
            'denied' => Yii::t('organization', 'Denied'),
            'awaitingMoreInfo' => Yii::t('organization', 'Awaiting more info'),
        ];
    }

    // RETURN ARRAY WITH ALL USERS OF A ORGANIZATION
    public static function getUsers() {
        $organizationUserRelation = OrganizationUserRelation::find()->where(['organization_id' => Yii::$app->user->identity->selectedOrganization->id])->all();
        $users = [];
        foreach ($organizationUserRelation as $c) {
            $user = User::findOne(['id' => $c->user_id]);
            if (isset($user)) {
                $users[$c->user_id] = $user->first_name . ' ' . $user->last_name;
            }
        }
        return $users;
    }

    // GET ORGANIZATION BY USER MODEL
    public function getOrganizationByUser(int $createdBy): ?Organization {
        return Organization::findOne(['created_by' => $createdBy]);
    }

    // RETURN PAIWISE FEE
    public function getPaiwiseFee(): float {
        return 1.5;
    }

    // ACTION IDENTITY
    public static function findIdentity($id) {
        return self::findOne($id);
    }


    // RETURN ARRAY WITH ALL AFFILIATE ORGANIZATIONs OF INSTANCE
    public static function getAffiliateOrganizations($instance) {
        $organizations = Organization::findAll(['instance' => $instance]);
        $array = [];
        foreach ($organizations as $c) {
            $organizationModuleRelation = OrganizationModuleRelation::findAll(['organization_id' => $c, 'module_id' => 'affiliate']);
            if (isset($organizationModuleRelation)) {
                foreach ($organizationModuleRelation as $organization) {
                    $organizationModel = Organization::findOne(['id' => $organization->organization_id]);
                    $array[$organizationModel->id] = $organizationModel->name;
                }
            }
        }
        return $array;
    }

    // RETURN ARRAY WITH ALL AFFILIATE ORGANIZATIONs OF A ORGANIZATION
    public static function getMyAffiliateOrganizations($organizationID) {
        $organizationSetting = OrganizationSetting::findAll(['setting' => 'affiliated', 'value' => $organizationID]);
        $array = [];
        foreach ($organizationSetting as $organization) {
            $organizationModel = Organization::findOne(['id' => $organization->organization_id]);
            $array[$organizationModel->id] = $organizationModel->name;
        }
        return $array;
    }

    public function collectInfo() {
        $infoArr = [];
        $infoArr['modelName'] = Yii::t('core_model', 'Organization');
        $infoArr['objectName'] = ($this->name ?? '');
        return $infoArr;
    }

    public function setDetails($array)
    {
        foreach ($array as $detail => $value) {
            $organizationDetail = OrganizationDetail::findOne(['organization_id' => $this->id, 'detail' => $detail]);
            if (!$organizationDetail) {
                $organizationDetail = new OrganizationDetail();
                $organizationDetail->organization_id = $this->id;
                $organizationDetail->detail = $detail;
                $syslogEvent = "organization_detail_added";
                $messageEvent = "added";
            } else {
                $syslogEvent = "organization_detail_updated";
                $messageEvent = "updated";
            }
            if ($organizationDetail->value !== $value) {
                $organizationDetail->value = $value;
                $organizationDetail->save();
                $systemLog = new SystemLog();
                $systemLog->user_id = (Yii::$app->user->identity->id ?? null);
                $systemLog->organization_id = $this->id;
                $systemLog->instance = $this->instance;
                $systemLog->event = $syslogEvent;
                $systemLog->message_short = ($this->name ?? ''). ' ' . $messageEvent ." detail: " . $detail;
                $systemLog->message = ($this->name ?? ''). ' ' . $messageEvent . " detail: " . $detail . " to: " . $value;
                $systemLog->data_format = json_encode(['detail' => $detail, 'value' => $value]);
            }
        }
        return null;
    }

    public function setSettings($array)
    {
        foreach ($array as $setting => $value) {
            $organizationSetting = OrganizationSetting::findOne(['organization_id' => $this->id, 'setting' => $setting]);
            if (!$organizationSetting) {
                $organizationSetting = new OrganizationSetting();
                $organizationSetting->organization_id = $this->id;
                $organizationSetting->setting = $setting;
                $syslogEvent = "organization_setting_added";
                $messageEvent = "added";
            } else {
                $syslogEvent = "organization_setting_updated";
                $messageEvent = "updated";
            }
            if ($organizationSetting->value !== $value) {
                $organizationSetting->value = $value;
                $organizationSetting->save();
                $systemLog = new SystemLog();
                $systemLog->user_id = (Yii::$app->user->identity->id ?? null);
                $systemLog->organization_id = $this->id;
                $systemLog->instance = $this->instance;
                $systemLog->event = $syslogEvent;
                $systemLog->message_short = ($this->name ?? ''). ' ' . $messageEvent ." detail: " . $setting;
                $systemLog->message = ($this->name ?? ''). ' ' . $messageEvent . " detail: " . $setting . " to: " . $value;
                $systemLog->data_format = json_encode(['detail' => $setting, 'value' => $value]);
            }
        }
        return null;
    }

}
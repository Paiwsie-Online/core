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
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $country
 * @property string|null $pnr
 * @property string|null $email
 * @property string $email_status
 * @property string|null $password
 * @property string $status
 * @property string $registered
 * @property string $auth_key
 * @property string $cid
 * @property string $access_token
 * @property array $organizationList
 * @property array $settingsList
 * @property array $selectedOrganization
 * @property string $organizationUserLevel
 * @property string $instance
 * @property string|null $phone
 * @property string|null $phone_status

 * @property Organization[] $organizations
 * @property OrganizationOrganizationGroupRight[] $organizationOrganizationGroupRights
 * @property OrganizationOrganizationRelation[] $organizationOrganizationRelations
 * @property OrganizationOrganizationUserRight[] $organizationOrganizationUserRights
 * @property OrganizationGroupModuleRight[] $organizationGroupModuleRights
 * @property OrganizationUserModuleRight[] $organizationUserModuleRights
 * @property OrganizationUserRelation[] $organizationUserRelations
 * @property OrganizationUsergroupUserRelation[] $organizationUsergroupUserRelations
 * @property Picture[] $pictures
 * @property SystemLog[] $systemLogs
 * @property UserLogin[] $userLogins
 * @property UserSetting[] $userSettings
 * @property UserDetail[] $userDetails
 * @property UserSetting $userSettingEmailVerificationCode
 * @property UserSetting $userSettingForgotPasswordVerificationCode
 * @property Picture $profile_picture
 * @property int $profile_picture_id
 * @property Notification[] $notifications
 */

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    public $full_name;
    public $name;
    public $temp_password;
    public $retype_password;
    public $old_password;
    public $emailVerificationCode;

    public static function tableName() {
        return 'user';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['registered'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
        ];
    }

    public function fields() {
        $fields = parent::fields();
        if ($this->scenario === 'registration') {
            unset($fields['auth_key'], $fields['password'], $fields['access_token']);
        }
        $fields = [
            'id',
            'first_name',
            'last_name',
            'country',
            'pnr',
            'profile_picture',
        ];
        return $fields;
    }

    public function extraFields() {
        // Put here a variable declared in property
        return [
            'userSettings',
            'userDetails',
            'access_token'
        ];
    }

    public function rules() {
        return [
            [['auth_key', 'access_token'], 'required'],
            [['first_name', 'last_name', 'profile_picture', 'profile_picture_id'], 'safe'],
            ['reCaptcha', 'required', 'except' => 'noCaptcha', 'on' => 'Captcha'],
            [['email_status', 'status'], 'string'],
            [['registered', 'phone', 'phone_status'/*, 'height'*/], 'safe'],
            [['first_name', 'last_name', 'auth_key', 'access_token', 'instance'], 'string', 'max' => 128],
            [['country'], 'string', 'max' => 16],
            [['pnr'], 'string', 'max' => 64],
            [['email'], 'string', 'max' => 256],
            [['password'], 'string', 'max' => 512],
            ['email', 'required', 'on' => ['registration', 'addemailpw', 'echange', 'addemail']],
            [['email'], 'email','message' => "The email isn't the correct format", 'on'=>['pwreset_send', 'registration', 'pwreset', 'addemailpw', 'echange']],
            ['email', 'checkEmailUniqueness', 'on' => ['registration', 'echange', 'addemailpw', 'addemail']],
            ['temp_password', 'required', 'on' => ['pwreset', 'addemailpw', 'registration', 'pwchange', 'registrationMobile', 'pwreset2']],
            ['temp_password', 'string', 'length' =>[6,24]],
            ['temp_password', 'match', 'pattern' =>'/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{1,25}$/', 'message' => Yii::t('user', 'The password must contain at least one lower case and one upper case character and at least one number!')],
            ['old_password', 'required', 'on' => ['pwchange', 'echange', 'pchange']],
            ['old_password', 'validateOldPassword', 'on' => ['pwchange', 'echange', 'pchange']],
            ['old_password', 'string', 'length' =>[6,24]],
            ['retype_password', 'required', 'on' => ['registration', 'pwreset', 'addemailpw', 'registrationMobile', 'pwreset2', 'addphonepw', 'pwchange']],
            ['retype_password', 'compare', 'compareAttribute' => 'temp_password', 'message' => Yii::t('user', 'Passwords do not match!')],
            ['retype_password', 'string', 'length' =>[6,24]],
            [['cid', 'pnr'], 'string', 'max' => 45],
            [['emailVerificationCode'], 'string', 'max' => 45],
            [['emailVerificationCode'], 'required', 'on' => ['emailVerify']],
            /*[['forgotPasswordVerificationCode'], 'string', 'max' => 45],
            [['forgotPasswordVerificationCode'], 'required', 'on' => ['forgotPasswordVerify']],*/
            ['phone', 'required', 'on' => ['registrationMobile', 'pchange', 'addphone', 'addphonepw']],
            ['phone', 'checkPhoneUniqueness', 'on' => ['registrationMobile', 'pchange', 'addphone', 'addphonepw']],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['registrationMobile'] = ['phone', 'first_name', 'last_name', 'temp_password', 'retype_password'];
        $scenarios['registrationAPI'] = ['email', 'temp_password', 'retype_password'];
        $scenarios['registration'] = ['email', 'first_name', 'last_name', 'temp_password', 'retype_password'];
        $scenarios['login'] = ['access_token'];
        $scenarios['emailVerify'] = ['access_token'];
        $scenarios['addemailpw'] = ['email', 'temp_password', 'retype_password'];
        $scenarios['addphonepw'] = ['phone', 'temp_password', 'retype_password'];
        $scenarios['addemail'] = ['email'];
        $scenarios['forgotpw'] = ['email'];
        $scenarios['resendcode'] = ['email'];
        $scenarios['forgotPasswordVerify'] = ['email', 'temp_password', 'retype_password'];
        $scenarios['addphone'] = ['phone'];
        $scenarios['echange'] = ['email', 'old_password'];
        $scenarios['pchange'] = ['phone', 'old_password'];
        $scenarios['pwchange'] = ['old_password', 'temp_password', 'retype_password'];
        $scenarios['pwreset_send'] = ['email'];
        $scenarios['pwreset'] = ['temp_password', 'retype_password'];
        $scenarios['pwreset2'] = ['temp_password', 'retype_password'];
        return $scenarios;
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'first_name' => Yii::t('core_model', 'First Name') . '*',
            'last_name' => Yii::t('core_model', 'Last Name') . '*',
            'country' => Yii::t('core_model', 'Country'),
            'pnr' => Yii::t('core_model', 'Pnr'),
            'email' => Yii::t('core_model', 'Email'),
            'email_status' => Yii::t('core_model', 'Email Status'),
            'password' => Yii::t('core_model', 'Password'),
            'status' => Yii::t('core_model', 'Status'),
            'registered' => Yii::t('core_model', 'Registered'),
            'auth_key' => Yii::t('core_model', 'Auth Key') . '*',
            'access_token' => Yii::t('core_model', 'Access Token') . '*',
            'temp_password' => Yii::t('core_model','Password'),
            'retype_password' => Yii::t('core_model','Retype Password'),
            'old_password' => Yii::t('core_model','Old Password'),
            'cid' => Yii::t('core_model', 'Cid'),
            'instance'  =>  Yii::t('core_model', 'Instance'),
            'full_name'  =>  Yii::t('core_model', 'Name'),
            'phone'  =>  Yii::t('core_model', 'Phone'),
            'phone_status'  =>  Yii::t('core_model', 'Phone Status'),
        ];
    }

    // TO PUT VALUE INTO PUBLIC VARIABLE
    public function afterFind()
    {
        $this->name = ($this->first_name ?? '').' '.($this->last_name ?? '');
        parent::afterFind(); // TODO: Change the autogenerated stub
    }

    public static function findByCountryPnr($country, $pnr, $instance) {
        return self::find()->where(['country' => $country, 'pnr' => $pnr, 'instance' => $instance])->one();
    }

    public static function getUserName($id = null) {
        if (!isset($id) && !isset(Yii::$app->user->identity->id)) {
            return null;
        }
        if (!isset($id)) {
            $id = Yii::$app->user->identity->id;
        }
        $user = self::find()->where(['id' => $id])->one();
        return ($user->first_name ?? '').' '.($user->last_name ?? '');
    }

    // VALIDATION UNIQ EMAIL WITH INSTANCE
    public function checkEmailUniqueness($attribute, $params) {
        $model = User::find()->where(['email' => $this->email, 'instance' => 'smartadmin'/*\Yii::$app->params['default_site_settings']['instance']*/])->one();
        if ($model !== null) {
            $this->addError('email', Yii::t('core_system','This email has already been taken, Email must be unique for login'));
        }
    }

    // VALIDATION UNIQ PHONE WITH INSTANCE
    public function checkPhoneUniqueness($attribute, $params) {
        $model = User::find()->where(['phone' => $this->phone, 'instance' => Yii::$app->params['default_site_settings']['instance']])->one();
        if ($model !== null) {
            $this->addError('phone', Yii::t('core_system','This phone has already been taken, Phone must be unique for login'));
        }
    }

    // GET ORGANIZATION MODEL
    public function getOrganizations() {
        return $this->hasMany(Organization::className(), ['created_by' => 'id']);
    }

    // RETURN ARRAY ORGANIZATION LIST BY USER
    public function getOrganizationList() {
        $temp_list = $this->hasMany(Organization::className(), ['id' => 'organization_id'])->viaTable('organization_user_relation', ['user_id' => 'id'], function($query){
            $query->andWhere(['status' => 'accepted']);
        })->asArray()->all();
        return ArrayHelper::map($temp_list, 'id', 'name');
    }

    // GET ORGANIZATION ORGANIZATION GROUP RIGHTS MODEL
    public function getOrganizationOrganizationGroupRights() {
        return $this->hasMany(OrganizationOrganizationGroupRight::className(), ['created_by' => 'id']);
    }

    // GET ORGANIZATION ORGANIZATION RELATION MODEL
    public function getOrganizationOrganizationRelations() {
        return $this->hasMany(OrganizationOrganizationRelation::className(), ['created_by' => 'id']);
    }

    // GET ORGANIZATION ORGANIZATION USER RIGHTS MODEL
    public function getOrganizationOrganizationUserRights() {
        return $this->hasMany(OrganizationOrganizationUserRight::className(), ['created_by' => 'id']);
    }

    // GET ORGANIZATION GROUP MODULE RIGHTS MODEL
    public function getOrganizationGroupModuleRights() {
        return $this->hasMany(OrganizationGroupModuleRight::className(), ['created_by' => 'id']);
    }

    // GET ORGANIZATION USER MODULE RIGHTS MODEL
    public function getOrganizationUserModuleRights() {
        return $this->hasMany(OrganizationUserModuleRight::className(), ['created_by' => 'id']);
    }

    // GET ORGANIZATION USER RELATION MODEL
    public function getOrganizationUserRelations() {
        return $this->hasMany(OrganizationUserRelation::className(), ['user_id' => 'id']);
    }

    // GET ORGANIZATION USER RELATION BY ORGANIZATION MODEL
    public function getOrganizationUserRelation() {
        return $this->hasOne(OrganizationUserRelation::className(), ['user_id' => 'id', 'selected_organization' => 1]);
    }

    // GET ORGANIZATION USERGROUP USER RELATION MODEL
    public function getOrganizationUsergroupUserRelations() {
        return $this->hasMany(OrganizationUsergroupUserRelation::className(), ['created_by' => 'id']);
    }

    // GET SYSTEM LOG MODEL
    public function getSystemLogs() {
        return $this->hasMany(SystemLog::className(), ['user_id' => 'id']);
    }

    // GET USER LOGIN MODEL
    public function getUserLogins() {
        return $this->hasMany(UserLogin::className(), ['user_id' => 'id']);
    }

    // GET LAST USER LOGIN MODEL
    public function getLastUserLogin() {
        return $this->hasOne(UserLogin::className(), ['user_id' => 'id'])->orderBy(['user_login.logged'=>SORT_DESC]);
    }

    // GET USER SETTINGS MODEL
    public function getUserSettings() {
        return $this->hasMany(UserSetting::className(), ['user_id' => 'id']);
    }

    // GET USER DETAILS MODEL
    public function getUserDetails() {
        return $this->hasMany(UserDetail::className(), ['user_id' => 'id']);
    }

    // RETURN ARRAY SETTINGS LIST BY USER
    public function getSettingsList($user_id = null) {
        if ($user_id == null) {
            $user_id = Yii::$app->user->identity->id;
        }
        $query = UserSetting::find()->where(['user_id' => $user_id])->orderBy(['setting' => SORT_ASC]);
        $temp_list = $query->all();
        return ArrayHelper::map($temp_list, 'setting', 'value');
    }

    // GET USER MODEL BY EMAIL AND INSTANCE
    public static function findByEmail($email, $instance) {
        return self::find()->where(['email' => $email, 'instance' => $instance])->one();
    }

    // ACTION VALIDATE PASSWORD
    public function validatePassword($password) {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    // ACTION IDENTITY
    public static function findIdentity($id) {
        return self::findOne($id);
    }

    // ACTION IDENTITY BY ACCESS TOKEN
    public static function findIdentityByAccessToken($token, $type = null) {
        return self::findOne(['access_token' => $token]);
    }

    // RETURN USER ID
    public function getId() {
        return $this->id;
    }

    // RETURN USER AUTH KEY
    public function getAuthKey() {
        return $this->auth_key;
    }

    // ACTION VALIDATE AUTH KAY
    public function validateAuthKey($authKey) {
        return $this->auth_key === $authKey;
    }

    // RETURN USER AUTH KEY
    public function getAccessToken() {
        return $this->access_token;
    }

    // ACTION VALIDATE AUTH KAY
    public function validateAccessToken($accessToken) {
        return $this->access_token === $accessToken;
    }

    // ACTION VALIDATE OLD PASSWORD
    public function ValidateOldPassword($attribute, $params) {
        $result = Yii::$app->getSecurity()->validatePassword($this->old_password, $this->password);
        if (!$result) {
            $this->addError($attribute, Yii::t('core_user', 'Your current password is not valid!'));
            return false;
        }
        return true;
    }

    // GET SELECTED ORGANIZATION MODEL
    public function getSelectedOrganization() {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id'])->viaTable('organization_user_relation', ['user_id' => 'id'], function($query){
            $query->andWhere(['selected_organization' => 1]);
        });
    }

    // ACTION HAS ACCESS
    public function hasAccess($moduleID, $right, $returnIcon = false, $organization_id = null) {
        $accessRight = 'right_'.$right;
        $module = Module::find()->where(['id' => $moduleID])->one();
        if ($module) {
            $selectedOrganization = Yii::$app->user->identity->selectedOrganization;
            if ($selectedOrganization) {
                if ($organization_id === null) {
                    $organization_id = $selectedOrganization['id'];
                }
            }
            if (!$organization_id) {
                return false;
            }
            $organizationUserRelation = OrganizationUserRelation::find()->where(['organization_id' => $organization_id, 'user_id' => $this->id, 'status' => 'accepted'])->one();
            if ($organizationUserRelation) {
                if ($moduleID !== 'siteAdmin' && $moduleID !== 'systemAdmin') {
                    // CHECK IF HAS SITE ADMIN
                    $organizationModuleRelation = OrganizationModuleRelation::findOne(['organization_id' => $organization_id, 'module_id' => 'siteAdmin']);
                    if ($organizationModuleRelation) {
                        if ($this->getOrganizationUserLevel($organization_id) === 'admin' || $this->getOrganizationUserLevel($organization_id) === 'owner') {
                            return ($returnIcon ? '<i class="fas fa-check-square fa-2x text-secondary"></i>' : true);
                        }
                        $organizationUserModuleRights = OrganizationUserModuleRight::find()->where(['ou_relation_id' => $organizationUserRelation->id, 'cmr_id' => $organizationModuleRelation->id])->one();
                        if ($organizationUserModuleRights) {
                            if ($organizationUserModuleRights->{$accessRight} === 1) {
                                return ($returnIcon ? '<i class="far fa-check-square fa-2x"></i>' : true);
                            }
                        }
                        $organizationUsergroupUserRelation = OrganizationUsergroupUserRelation::find()->where(['ou_relation_id' => $organizationUserRelation->id])->all();
                        if ($organizationUsergroupUserRelation) {
                            foreach ($organizationUsergroupUserRelation as $cuur) {
                                $organizationGroupModuleRights = OrganizationGroupModuleRight::find()->where(['group_id' => $cuur->group_id, 'cmr_id' => $organizationModuleRelation->id])->one();
                                if (isset($organizationGroupModuleRights) && $organizationGroupModuleRights->{$accessRight} === 1) {
                                    return ($returnIcon ? '<i class="fas fa-check-square fa-2x"></i>' : true);
                                }
                            }
                        }
                    }
                    // CHECK IF HAS SYSTEM ADMIN
                    $organizationModuleRelation = OrganizationModuleRelation::findOne(['organization_id' => $organization_id, 'module_id' => 'systemAdmin']);
                    if ($organizationModuleRelation) {
                        if ($this->getOrganizationUserLevel($organization_id) === 'admin' || $this->getOrganizationUserLevel($organization_id) === 'owner') {
                            return ($returnIcon ? '<i class="fas fa-check-square fa-2x text-secondary"></i>' : true);
                        }
                        $organizationUserModuleRights = OrganizationUserModuleRight::find()->where(['ou_relation_id' => $organizationUserRelation->id, 'cmr_id' => $organizationModuleRelation->id])->one();
                        if ($organizationUserModuleRights) {
                            if ($organizationUserModuleRights->{$accessRight} === 1) {
                                return ($returnIcon ? '<i class="far fa-check-square fa-2x"></i>' : true);
                            }
                        }
                        $organizationUsergroupUserRelation = OrganizationUsergroupUserRelation::find()->where(['ou_relation_id' => $organizationUserRelation->id])->all();
                        if ($organizationUsergroupUserRelation) {
                            foreach ($organizationUsergroupUserRelation as $cuur) {
                                $organizationGroupModuleRights = OrganizationGroupModuleRight::find()->where(['group_id' => $cuur->group_id, 'cmr_id' => $organizationModuleRelation->id])->one();
                                if (isset($organizationGroupModuleRights) && $organizationGroupModuleRights->{$accessRight} === 1) {
                                    return ($returnIcon ? '<i class="fas fa-check-square fa-2x"></i>' : true);
                                }
                            }
                        }
                    }
                }
                $organizationModuleRelation = OrganizationModuleRelation::find()->where(['organization_id' =>  $organization_id, 'module_id' => $module->id])->one();
                if ($organizationModuleRelation) {
                    if ($this->getOrganizationUserLevel($organization_id) === 'admin' || $this->getOrganizationUserLevel($organization_id) === 'owner') {
                        return ($returnIcon ? '<i class="fas fa-check-square fa-2x text-secondary"></i>' : true);
                    }
                    $organizationUserModuleRights = OrganizationUserModuleRight::find()->where(['ou_relation_id' => $organizationUserRelation->id, 'cmr_id' => $organizationModuleRelation->id])->one();
                    if ($organizationUserModuleRights) {
                        if ($organizationUserModuleRights->{$accessRight} === 1) {
                            return ($returnIcon ? '<i class="far fa-check-square fa-2x"></i>' : true);
                        }
                        if ($organizationUserModuleRights->{$accessRight} === 0) {
                            return ($returnIcon ? '<i class="far fa-times-square fa-2x"></i>' : false);
                        }
                    }
                    $organizationUsergroupUserRelation = OrganizationUsergroupUserRelation::find()->where(['ou_relation_id' => $organizationUserRelation->id])->all();
                    if ($organizationUsergroupUserRelation) {
                        foreach ($organizationUsergroupUserRelation as $cuur) {
                            $organizationGroupModuleRights = OrganizationGroupModuleRight::find()->where(['group_id' => $cuur->group_id, 'cmr_id' => $organizationModuleRelation->id])->one();
                            if (isset($organizationGroupModuleRights) && $organizationGroupModuleRights->{$accessRight} === 1) {
                                return ($returnIcon ? '<i class="fas fa-check-square fa-2x"></i>' : true);
                            }
                        }
                    }
                }
            }
        }
        return ($returnIcon ? '<i class="fas fa-times-square fa-2x"></i>' : false);
    }

    // GENERATE ACCE TOKEN WHEN A USER IS REGISTERING
    public function generateAccessToken() {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    // ACTION CHECK USER LEVEL
    public function checkUserLevel() {
        $organizationUserRelation = OrganizationUserRelation::findOne(['organization_id' => Yii::$app->user->identity->selectedOrganization->id, 'user_id' => Yii::$app->user->identity->id]);
        $hasAccess = false;
        if (isset($organizationUserRelation) && $organizationUserRelation->user_level !== 'user') {
            $hasAccess = true;
        }
        return $hasAccess;
    }

    // RETURN ORGANIZATION USER LEVEL
    public function getOrganizationUserLevel($organization_id = null){
        if ($organization_id === null) {
            if (isset($this->selectedOrganization['id'])) {
                $organization_id = $this->selectedOrganization['id'];
            }
        }
        if (isset($organization_id)) {
            $organizationUserRelation = OrganizationUserRelation::find()->where(['organization_id' => $organization_id, 'user_id' => $this->id, 'status' => 'accepted'])->one();
            if ($organizationUserRelation) {
                return $organizationUserRelation->user_level;
            }
        }
        return 'Guest';
    }

    // RETURN FULL USER NAME
    public static function getUsernames() {
        $user = self::find()->all();
        $users = [];
        foreach ($user as $u) {
            $users [] = $u->first_name . ' ' . $u->last_name;
        }
        return $users;
    }

    // RETURN ARRAY COUNTRY
    public static function getCountry() {
        $temp_list = self::find()->indexBy('country')->all();
        return ArrayHelper::map($temp_list, 'country', 'country');
    }

    // RETURN ARRAY INSTANCES
    public static function getInstances() {
        $temp_list = self::find()->indexBy('instance')->all();
        return ArrayHelper::map($temp_list, 'instance', 'instance');
    }

    // DROPDOWN ARRAY EMAIL STATUS (TRANSLATIONS)
    public static function emailStatus() {
        return array (
            'unverified' => Yii::t('user', 'Unverified'),
            'verified' => Yii::t('user', 'Verified')
        );
    }

    // DROPDOWN ARRAY USER STATUS (TRANSLATIONS)
    public static function userStatus() {
        return array (
            'registered' => Yii::t('user', 'Registered'),
            'verified' => Yii::t('user', 'Verified'),
            'blocked' => Yii::t('user', 'Blocked')
        );
    }

    // ACTION MERGE ACCOUNTS
    public static function mergeAccounts(User $mergeIntoAccount, User $mergeFromAccount) {
        /* Manual controls */
        /*
         * organization_organization_user_rights -> user_id
         */
        $directUpdates = [
            'organization' => 'created_by',
            'organization_organization_group_rights' => 'created_by',
            'organization_organization_relation' => 'created_by',
            'organization_organization_user_rights' => 'created_by',
            'organization_group_module_rights' => 'created_by',
            'organization_usergroup' => 'created_by',
            'organization_usergroup_user_relation' => 'created_by',
            'organization_user_module_rights' => 'created_by',
            'organization_user_relation' => 'created_by',
            'picture'   =>  'created_by',
            'user_login'    =>  'user_id',
            'system_log' => 'user_id',
        ];
        $command = Yii::$app->db->createCommand();
        foreach ($directUpdates as $key => $value) {
            $command->update("{$key}", ["{$value}" => $mergeIntoAccount->id], "{$value}=:id", [':id' => $mergeFromAccount->id])->execute();
        }
        //Update system_log table
        $systemLogs = SystemLog::find()->andFilterWhere(['like', 'data_format', ':' . $mergeFromAccount->id])->all();
        $searchArray = ['user', 'addedUser', 'removedUser'];
        foreach ($systemLogs as $sL) {
            $dataFormat = json_decode($sL->data_format, true);
            foreach ($searchArray as $key) {
                if (isset($dataFormat["{$key}"]) && (int)$dataFormat["{$key}"] === $mergeFromAccount->id) {
                    $dataFormat["{$key}"] = $mergeIntoAccount->id;
                }
            }
            $sL->data_format = json_encode($dataFormat);
            $sL->save();
        }
        //Update organization_user_relation table
        $organizationUserRelation = OrganizationUserRelation::find()->where(['user_id' => $mergeFromAccount->id])->all();
        foreach ($organizationUserRelation as $cur) {
            $secondRelation = OrganizationUserRelation::findOne(['organization_id' => $cur->organization_id, 'user_id' => $mergeIntoAccount->id]);
            if ($secondRelation) {
                $newRelation = new OrganizationUserRelation();
                $newRelation->organization_id = $secondRelation->organization_id;
                $newRelation->user_id = $secondRelation->user_id;
                $newRelation->title = $secondRelation->title;
                //$newRelation->created_by = $secondRelation->created_by;
                // Compare user levels
                if ($cur->user_level === 'owner' || $secondRelation->user_level === 'owner') {
                    $newRelation->user_level = 'owner';
                } elseif ($cur->user_level === 'admin' || $secondRelation->user_level === 'admin') {
                    $newRelation->user_level = 'admin';
                } else {
                    $newRelation->user_level = 'user';
                }
                // Compare added use oldest
                $newRelation->created_at = ($cur->created_at < $secondRelation->created_at ? $cur->created_at : $secondRelation->created_at);
                // Compare status priority accepted, pending, ignore declined and Status changed use from the used status
                if ($cur->status === 'accepted' || $secondRelation->status === 'accepted') {
                    if ($cur->status === 'accepted' && $secondRelation->status === 'accepted') {
                        $newRelation->status_changed = ($cur->status_changed < $secondRelation->status_changed ? $cur->status_changed : $secondRelation->status_changed);
                    } elseif ($secondRelation->status === 'accepted') {
                        $newRelation->status_changed = $secondRelation->status_changed;
                    } else {
                        $newRelation->status_changed = $cur->status_changed;
                    }
                    $newRelation->status = 'accepted';
                } elseif ($cur->status === 'pending' || $secondRelation->status === 'pending') {
                    if ($cur->status === 'pending' && $secondRelation->status === 'pending') {
                        $newRelation->status_changed = ($cur->status_changed < $secondRelation->status_changed ? $cur->status_changed : $secondRelation->status_changed);
                    } elseif ($secondRelation->status === 'pending') {
                        $newRelation->status_changed = $secondRelation->status_changed;
                    } else {
                        $newRelation->status_changed = $cur->status_changed;
                    }
                    $newRelation->status = 'pending';
                }
                $newRelation->selected_organization = $secondRelation->selected_organization;
                $newRelation->save();

                $organizationUsergroupUserRaltion = OrganizationUsergroupUserRelation::find()->where(['ou_relation_id' => $cur->id])->all();
                foreach ($organizationUsergroupUserRaltion as $cuur) {
                    $secondGroupRelation = OrganizationUsergroupUserRelation::findOne(['ou_relation_id' => $secondRelation->id, 'group_id' => $cuur->group_id]);
                    if (!$secondGroupRelation) {
                        $cuur->ou_relation_id = $newRelation->id;
                        $cuur->save();
                    }
                }
                $organizationUserModuleRights = OrganizationUserModuleRight::find()->where(['ou_relation_id' => $cur->id])->all();
                foreach ($organizationUserModuleRights as $cumr) {
                    $secondModuleRights = OrganizationUserModuleRight::findOne(['ou_relation_id' => $secondRelation->id, 'cmr_id' => $cumr->cmr_id]);
                    if ($secondModuleRights) {
                        if ($cumr->right_create === 1) {
                            $secondModuleRights->right_create = 1;
                        }
                        if ($cumr->right_read === 1) {
                            $secondModuleRights->right_read = 1;
                        }
                        if ($cumr->right_update === 1) {
                            $secondModuleRights->right_update = 1;
                        }
                        if ($cumr->right_delete === 1) {
                            $secondModuleRights->right_delete = 1;
                        }
                        $secondModuleRights->ou_relation_id = $newRelation->id;
                        $secondModuleRights->save();
                        $cumr->delete();
                    } else {
                        $cumr->ou_relation_id = $newRelation->id;
                        $cumr->save();
                    }
                }
                $organizationUserRelationInvitation = OrganizationUserRelationInvitation::find()->where(['our_id' => $cur->id])->all();
                foreach ($organizationUserRelationInvitation as $curi) {
                    $curi->our_id = $newRelation->id;
                    $curi->save();
                }
                $secondRelation->delete();
                $cur->delete();
            } else {
                $cur->user_id = $mergeIntoAccount->id;
                $cur->save();
            }
        }
        if (!$mergeIntoAccount->first_name || ($mergeIntoAccount->status !== 'verified' && $mergeFromAccount->status === 'verified')) {
            $mergeIntoAccount->first_name = $mergeFromAccount->first_name;
        }
        if (!$mergeIntoAccount->last_name || ($mergeIntoAccount->status !== 'verified' && $mergeFromAccount->status === 'verified')) {
            $mergeIntoAccount->last_name = $mergeFromAccount->last_name;
        }
        if (!$mergeIntoAccount->country || ($mergeIntoAccount->status !== 'verified' && $mergeFromAccount->status === 'verified')) {
            $mergeIntoAccount->country = $mergeFromAccount->country;
        }
        if (!$mergeIntoAccount->pnr || ($mergeIntoAccount->status !== 'verified' && $mergeFromAccount->status === 'verified')) {
            $mergeIntoAccount->pnr = $mergeFromAccount->pnr;
        }
        if (!$mergeIntoAccount->email) {
            $mergeIntoAccount->email = $mergeFromAccount->email;
            $mergeIntoAccount->email_status = $mergeFromAccount->email_status;
        }
        if (!$mergeIntoAccount->password) {
            $mergeIntoAccount->password = $mergeFromAccount->password;
        }
        $mergeIntoAccount->save();
        $mergeFromAccount->delete();
        Yii::$app->user->logout();
        return true;
    }

    public static function updateSetting($setting, $value, $id = null) {
        if ($id === null) {
            $id = Yii::$app->user->identity->id;
        }
        $userSetting = UserSetting::findOne(['user_id' => $id, 'setting' => $setting]);
        if (!$userSetting) {
            $userSetting = new UserSetting();
            $userSetting->user_id = $id;
            $userSetting->setting = $setting;
        }
        $userSetting->value = $value;
        if ($userSetting->save()) {
            return true;
        }
        return false;
    }

    public function getUserSettingEmailVerificationCode() {
        $userSetting = UserSetting::findOne(['user_id' => $this->id, 'setting' => 'emailVerificationCode']);
        if (isset($userSetting)) {
            return $userSetting->value;
        }
        return false;
    }

    public function getUserSettingForgotPasswordVerificationCode() {
        $userSetting = UserSetting::findOne(['user_id' => $this->id, 'setting' => 'forgotPasswordVerificationCode']);
        if (isset($userSetting)) {
            $settingValue = json_decode($userSetting->value);
            return $settingValue;
        }
        return false;
    }

    public function getProfile_picture() {
        $userDetail = UserDetail::findOne(['user_id' => $this->id, 'detail' => 'profilePicture']);
        if (isset($userDetail)) {
            $pictureModel = Picture::findOne((int)$userDetail->value);
            $pictureModel->uri = Yii::$app->params['default_site_settings']['api_url'] . $pictureModel->uri;
            return $pictureModel;
        }
        return null;
    }

    // SET PROFILE PICTURE
    public function setProfile_picture_id() {
        if (isset(Yii::$app->request->queryParams['id'])) {
            $id = Yii::$app->request->queryParams['id'];
        } else {
            $id = Yii::$app->user->id;
        }
        if (isset(Yii::$app->request->bodyParams['profile_picture_id'])) {
            //$validPic = GalleryPictureRelation::find()->leftJoin('gallery', 'gallery_id=gallery.id')->leftJoin('user', 'gallery.model_id=user.id')->where(['gallery.model' => 'common\models\User', 'user.id' => $id, 'gallery_picture_relation.picture_id' => Yii::$app->request->bodyParams['profile_picture_id']])->one();
            $validPic = Picture::findOne(Yii::$app->request->bodyParams['profile_picture_id']);
            if ($validPic) {
                $userDetail = UserDetail::findOne(['user_id' => $id, 'detail' => 'profilePicture']);
                if (!isset($userDetail)) {
                    $userDetail = new UserDetail();
                    $userDetail->user_id = $id;
                    $userDetail->detail = 'profilePicture';
                }
                $userDetail->value = (string)Yii::$app->request->bodyParams['profile_picture_id'];
                $userDetail->save();
            } else {    
                throw new NotFoundHttpException(Yii::t('core_system', 'The requested image does not exist or not belong to this user'));
            }
        }
    }

    // CHECK IF CURRENT USER HAVE RIGHTS TO PERFORM ACTION
    public static function userHaveRights($uid = null) {
        $accessToken = explode(' ', Yii::$app->request->headers['authorization'])[1];
        $user_id = User::findIdentityByAccessToken($accessToken);
        if ($uid === null) {
            if (isset($_GET, $_GET['id'])) {
                $uid = (int)$_GET['id'];
            } else {
                throw new ServerErrorHttpException(Yii::t('core_system', 'User not set'));
            }
        }
        if ($user_id && $user_id->id === $uid) {
            return true;
        } else {
            throw new NotAcceptableHttpException(Yii::t('core_system', 'You do not have rights to manage this user'));
        }
    }

    public function collectInfo() {
        return [
            'modelName' => Yii::t('core_model', 'User'),
            'objectName' => ($this->first_name ?? '').' '.($this->last_name ?? ''),
        ];
    }

    public function getNotifications($category = null, $status = 'unread')
    {
        $query = Notification::find()->leftJoin('user_notification_relation', 'user_notification_relation.notification_id = notification.id')->where(['user_notification_relation.user_id' => $this->id]);
        if ($status) {
            $query->andWhere(['notification.status' => $status]);
        }
        if ($category) {
            $query->andWhere(['notification.category' => $category]);
        }
        return $query->all();
    }

    public function setDetails($array)
    {
        foreach ($array as $detail => $value) {
            $userDetail = UserDetail::findOne(['user_id' => $this->id, 'detail' => $detail]);
            if (!$userDetail) {
                $userDetail = new UserDetail();
                $userDetail->user_id = $this->id;
                $userDetail->detail = $detail;
                $syslogEvent = "user_detail_added";
                $messageEvent = "added";
            } else {
                $syslogEvent = "user_detail_updated";
                $messageEvent = "updated";
            }
            if ($userDetail->value !== $value) {
                $userDetail->value = $value;
                $userDetail->save();
                $systemLog = new SystemLog();
                $systemLog->user_id = $this->id;
                $systemLog->instance = $this->instance;
                $systemLog->event = $syslogEvent;
                $systemLog->message_short = ($this->first_name ?? '').' '.($this->last_name ?? '') . $messageEvent ." detail: " . $detail;
                $systemLog->message = ($this->first_name ?? '').' '.($this->last_name ?? '') . $messageEvent . " detail: " . $detail . " to: " . $value;
                $systemLog->data_format = json_encode(['detail' => $detail, 'value' => $value]);
            }
        }
        return null;
    }

}
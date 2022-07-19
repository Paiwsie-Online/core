<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\bootstrap4\Html;
use yii\db\ActiveRecord;
use yii\jui\DatePicker;

/**
 * @property int $id
 * @property string $key_type
 * @property string $key
 * @property string|null $instance
 * @property int|null $organization_id
 * @property int $created_at
 * @property int|null $created_by
 * @property string|null $key_config
 * @property string|null $expiry_date
 * @property string $status
 * @property string $type
 *
 * @property Organization $organization
 * @property User $createdBy
 * @property OrganizationApiKey[] $organizationApiKeys
 * @property SiteadminApiKey[] $siteadminApiKeys
 * @property SystemadminApiKey[] $systemadminApiKeys
 */

class ApiKey extends \yii\db\ActiveRecord {

    public $created_by_full_name;

    public static function tableName() {
        return 'api_key';
    }

    public function behaviors() {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class,
        ];
    }

    public function rules() {
        return [
            [['key_type', 'key', 'type'], 'required'],
            [['key_type', 'key_config', 'status', 'type'], 'string'],
            [['organization_id', 'created_by'], 'integer'],
            [['created_at', 'updated_by', 'updated_at', 'expiry_date'], 'safe'],
            [['key'], 'string', 'max' => 128],
            [['instance'], 'string', 'max' => 64],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'key_type' => Yii::t('core_model', 'Key Type') . '*',
            'key' => Yii::t('core_model', 'Key') . '*',
            'instance' => Yii::t('core_model', 'Instance'),
            'organization_id' => Yii::t('core_model', 'Organization ID'),
            'created_at' => Yii::t('core_model', 'Created'),
            'created_by' => Yii::t('core_model', 'Created By'),
            'updated_at' => Yii::t('core_model', 'Updated'),
            'updated_by' => Yii::t('core_model', 'Updated By'),
            'key_config' => Yii::t('core_model', 'Key Config'),
            'expiry_date' => Yii::t('core_model', 'Expiry Date'),
            'status' => Yii::t('core_model', 'Status'),
            'type' => Yii::t('core_model', 'Type') . '*',
            'created_by_full_name' => Yii::t('core_model', 'Created By'),
        ];
    }

    // GET ORGANIZATION MODEL
    public function getOrganization() {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    // GET USER MODEL
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    // GET ORGANIZATION API KEY MODEL
    public function getOrganizationApiKeys() {
        return $this->hasMany(OrganizationApiKey::className(), ['key_id' => 'id']);
    }

    // GET SITE ADMIN API KEY MODEL
    public function getSiteadminApiKeys() {
        return $this->hasMany(SiteadminApiKey::className(), ['key_id' => 'id']);
    }

    // GET SYSTEM ADMIN API KEY MODEL
    public function getSystemadminApiKeys() {
        return $this->hasMany(SystemadminApiKey::className(), ['key_id' => 'id']);
    }

    // RETURN KEY TYPE (DROPDOWN)
    public static function getKeyType() {
        return [
            'organization' => Yii::t('api_key', 'Organization'),
            'instance' => Yii::t('api_key', 'Instance'),
            'system' => Yii::t('api_key', 'System')
        ];
    }

    // RETURN TYPE (DROPDWON)
    public static function getType() {
        return [
            'live' => Yii::t('api_key', 'Live'),
            'test' => Yii::t('api_key', 'Test')
        ];
    }

    // RETURN STATUS (DROPDOWN)
    public static function getStatus() {
        return [
            'active' => Yii::t('api_key', 'Active'),
            'blocked' => Yii::t('api_key', 'Blocked'),
            'expired' => Yii::t('api_key', 'Expired'),
            'deleted' => Yii::t('api_key', 'Deleted'),
        ];
    }

    // RETURN ARRAY FOR INDEX ORGANIZATION WITHOUT USER SETTINGS
    public static function getIndexOrganizationNoSettings() {
        $columns = [
            [
                'attribute' =>  'key_config',
                'filter' => false,
                'label' => Yii::t('core_system', 'Key Name'),
                'value' =>  function($data) {
                    if (isset($data->key_config) && $data->key_config !== '') {
                        $keyConfigDecoded = json_decode($data->key_config);
                    }
                    if (isset($data->key_config, $keyConfigDecoded->name) && $keyConfigDecoded->name !== '' && $keyConfigDecoded->name !== ' ') {
                        return $keyConfigDecoded->name;
                    } else {
                        return Yii::t('core_system', 'Not Set');
                    }
                }
            ],
            [
                'attribute' =>  'key_type',
                'label' => Yii::t('core_system', 'Key Type'),
                'value' =>  function($data) {
                    return Yii::t('api_key', ucfirst($data->key_type));
                }
            ],
            [
                'attribute' =>  'created_at',
                'filter' => '<div class="row" style="width: 330px">
                            <div class="col-md-5">' . DatePicker::widget([
                        'name'  => 'ApiKeySearch[createdStart]',
                        'value'  => ($_GET['ApiKeySearch']['createdStart'] ?? ''),
                        'dateFormat' => 'php:Y-m-d',
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ]) . '</div>
                            <div class="col-md-1 mt-2 mr-3">
                                <i class="fas fa-horizontal-rule"></i>
                            </div>
                            <div class="col-md-5">' . DatePicker::widget([
                        'name'  => 'ApiKeySearch[createdEnd]',
                        'value'  => ($_GET['ApiKeySearch']['createdEnd'] ?? ''),
                        'dateFormat' => 'php:Y-m-d',
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ]) . '</div>
                            </div>',
                'value' =>  function($data) {
                    return ($data->created_at ? Yii::$app->formatter->asDatetime($data->created_at, 'php:Y-m-d H:i') : Yii::t('core_system', 'Not Set'));
                }
            ],
            'created_by_full_name',
            [
                'attribute' =>  'expiry_date',
                'value' =>  function($data) {
                    return ($data->expiry_date ? Yii::$app->formatter->asDate($data->expiry_date, 'php:Y-m-d') : Yii::t('core_system', 'Not Set'));
                }
            ],
            [
                'attribute' =>  'status',
                'filter'    =>  ApiKey::getStatus(),
                'value' =>  function($data) {
                    return Yii::t('api_key', ucfirst($data->status));
                }
            ],
            [
                'attribute' =>  'type',
                'label' => Yii::t('core_model', 'Type'),
                'filter'    =>  ApiKey::getType(),
                'value' =>  function($data) {
                    return Yii::t('api_key', ucfirst($data->type));
                }
            ],
            [
                'attribute' =>  '',
                'format' => 'raw',
                'value' => function($data) {
                    $viewBtn = Html::a('<i class="fas fa-eye"></i>', ['view-organization', 'id' => $data->id]);
                    return ($viewBtn ?? '');
                }
            ],
        ];
        return $columns;
    }

    // RETURN ARRAY FOR INDEX SITE ADMIN WITHOUT USER SETTINGS
    public static function getIndexSiteAdminNoSettings() {
        $columns = [
            [
                'attribute' =>  'key_config',
                'filter' => false,
                'label' => Yii::t('core_system', 'Key Name'),
                'value' =>  function($data) {
                    if (isset($data->key_config) && $data->key_config !== '') {
                        $keyConfigDecoded = json_decode($data->key_config);
                    }
                    if (isset($data->key_config, $keyConfigDecoded->name) && $keyConfigDecoded->name !== '' && $keyConfigDecoded->name !== ' ') {
                        return $keyConfigDecoded->name;
                    } else {
                        return Yii::t('core_system', 'Not Set');
                    }
                }
            ],
            [
                'attribute' =>  'key_type',
                'label' => Yii::t('core_system', 'Key Type'),
                'value' =>  function($data) {
                    return Yii::t('api_key', ucfirst($data->key_type));
                }
            ],
            [
                'attribute' =>  'created_at',
                'filter' => '<div class="row" style="width: 330px">
                            <div class="col-md-5">' . DatePicker::widget([
                        'name'  => 'ApiKeySearch[createdStart]',
                        'value'  => ($_GET['ApiKeySearch']['createdStart'] ?? ''),
                        'dateFormat' => 'php:Y-m-d',
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ]) . '</div>
                            <div class="col-md-1 mt-2 mr-3">
                                <i class="fas fa-horizontal-rule"></i>
                            </div>
                            <div class="col-md-5">' . DatePicker::widget([
                        'name'  => 'ApiKeySearch[createdEnd]',
                        'value'  => ($_GET['ApiKeySearch']['createdEnd'] ?? ''),
                        'dateFormat' => 'php:Y-m-d',
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ]) . '</div>
                            </div>',
                'value' =>  function($data) {
                    return ($data->created_at ? Yii::$app->formatter->asDatetime($data->created_at, 'php:Y-m-d H:i') : Yii::t('core_system', 'Not Set'));
                }
            ],
            'created_by_full_name',
            [
                'attribute' =>  'expiry_date',
                'value' =>  function($data) {
                    return ($data->expiry_date ? Yii::$app->formatter->asDate($data->expiry_date, 'php:Y-m-d') : Yii::t('core_system', 'Not Set'));
                }
            ],
            [
                'attribute' =>  'status',
                'filter'    =>  ApiKey::getStatus(),
                'value' =>  function($data) {
                    return Yii::t('api_key', ucfirst($data->status));
                }
            ],
            [
                'attribute' =>  'type',
                'label' => Yii::t('core_model', 'Type'),
                'filter'    =>  ApiKey::getType(),
                'value' =>  function($data) {
                    return Yii::t('api_key', ucfirst($data->type));
                }
            ],
            [
                'attribute' =>  'instance',
                'filter'    =>  User::getInstances(),
                'visible'   =>  (Yii::$app->user->identity->hasAccess('systemAdmin', 'read')),
            ],
            [
                'attribute' =>  '',
                'format' => 'raw',
                'value' => function($data) {
                    if ($data->key_type === 'instance') {
                        $viewBtn = Html::a('<i class="fas fa-eye"></i>', ['view-site-admin', 'id' => $data->id]);
                    } else {
                        $viewBtn = Html::a('<i class="fas fa-eye"></i>', ['view-organization', 'id' => $data->id]);
                    }
                    return ($viewBtn ?? '');
                }
            ],
        ];
        return $columns;
    }

}
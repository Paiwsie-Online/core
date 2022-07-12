<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property int $organization_id
 * @property string $setting
 * @property string|null $value

 * @property Organization $organization
 */

class OrganizationSetting extends \yii\db\ActiveRecord {

    public $contact_phone;
    public $file;
    public $signature;
    public $inviteUser;

    public static function tableName() {
        return 'organization_setting';
    }

    public function rules() {
        return [
            [['organization_id', 'setting'], 'required'],
            [['organization_id'], 'integer'],
            [['value'], 'string'],
            [['setting'], 'string', 'max' => 128],
            [['organization_id', 'setting'], 'unique', 'targetAttribute' => ['organization_id', 'setting']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['contact_phone'], 'safe'],
            ['file', 'file',
                'skipOnEmpty' => true,
                'maxSize' => 2048*2048*2, //max size files 8 MB
                'tooBig' => Yii::t('core_system', 'The maximum size allowed is 8MB'), //max size error
                'minSize' => 10, //min size files 10 Bytes
                'tooSmall' => Yii::t('core_system', 'The minimum size allowed is 10Bytes'), //min size error
                'extensions' => implode(', ', Yii::$app->params['allowedExtensions']['images']),
                'wrongExtension' => Yii::t('core_system', 'The file extension is not allowed'), //extension file error
                'maxFiles' => 1,
                'tooMany' => Yii::t('core_system', 'The maximum number of files allowed is five'), //max number files error
            ],
        ];
    }

    public function attributeLabels() {
        return [
            'organization_id' => Yii::t('core_model', 'ID') . '*',
            'setting' => Yii::t('core_model', 'Setting') . '*',
            'value' => Yii::t('core_model', 'Value'),
        ];
    }

    public function getOrganization() {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    public static function findSetting($organization_id, string $setting, bool $returnValue = false) {
        $setting = self::findOne(['organization_id' => $organization_id, 'setting' => $setting]);
        if ($setting) {
            if ($returnValue) {
                return $setting->value;
            }
            return $setting;
        }
        return false;
    }

}
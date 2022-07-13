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
 * @property int $key_id
 * @property int $cmr_id
 * @property int $right_create
 * @property int $right_read
 * @property int $right_update
 * @property int $right_delete
 * @property string $rights_given
 * @property int|null $rights_given_by
 *
 * @property OrganizationModuleRelation $cmr
 * @property ApiKey $key
 * @property User $rightsGivenBy
 */

class OrganizationApiKey extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'organization_api_key';
    }

    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['rights_given_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['rights_given'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
        ];
    }

    public function rules() {
        return [
            [['key_id', 'cmr_id', 'right_create', 'right_read', 'right_update', 'right_delete'], 'required'],
            [['key_id', 'cmr_id', 'right_create', 'right_read', 'right_update', 'right_delete', 'rights_given_by'], 'integer'],
            [['rights_given'], 'safe'],
            [['cmr_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationModuleRelation::className(), 'targetAttribute' => ['cmr_id' => 'id']],
            [['key_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiKey::className(), 'targetAttribute' => ['key_id' => 'id']],
            [['rights_given_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['rights_given_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'key_id' => Yii::t('core_model', 'Key ID') . '*',
            'cmr_id' => Yii::t('core_model', 'Cmr ID') . '*',
            'right_create' => Yii::t('core_model', 'Right Create') . '*',
            'right_read' => Yii::t('core_model', 'Right Read') . '*',
            'right_update' => Yii::t('core_model', 'Right Update') . '*',
            'right_delete' => Yii::t('core_model', 'Right Delete') . '*',
            'rights_given' => Yii::t('core_model', 'Rights Given'),
            'rights_given_by' => Yii::t('core_model', 'Rights Given By'),
        ];
    }

    public function getCmr() {
        return $this->hasOne(OrganizationModuleRelation::className(), ['id' => 'cmr_id']);
    }

    public function getKey() {
        return $this->hasOne(ApiKey::className(), ['id' => 'key_id']);
    }

    public function getRightsGivenBy() {
        return $this->hasOne(User::className(), ['id' => 'rights_given_by']);
    }

}
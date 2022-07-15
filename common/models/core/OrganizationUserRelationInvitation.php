<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property int $id
 * @property string|null $sent_via
 * @property string|null $sent_to
 * @property string|null $cid
 * @property int|null $our_id
 * @property string|null $invite_params

 * @property OrganizationUserRelation $our
 */

class OrganizationUserRelationInvitation extends \yii\db\ActiveRecord {

    public $sent_to_email;
    public $sent_to_mobile;

    public static function tableName() {
        return 'organization_user_relation_invitation';
    }

    public function rules() {
        return [
            [['sent_to', 'sent_via'], 'required'],
            [['sent_via'], 'string'],
            [['our_id'], 'integer'],
            ['sent_to_email', 'required', 'when' => function($model){
                return $model->sent_via === 'email' && !isset($model->sent_to);
            }, 'whenClient' => "function (attribute, value){
                return $('#organizationuserrelationinvitation-sent_via').val() === 'email'
            }"],
            ['sent_to_mobile', 'required', 'when' => function($model){
                return $model->sent_via === 'sms' && !isset($model->sent_to);
            }, 'whenClient' => "function (attribute, value){
                return $('#organizationuserrelationinvitation-sent_via').val() === 'sms'
            }"],
            [['sent_to_email'], 'email','message' => Yii::t('core_system', 'The email is not the correct format')],
            [['sent_to_mobile'], 'number'],
            [['cid'], 'string', 'max' => 45],
            [['invite_params'], 'string'],
            [['our_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationUserRelation::className(), 'targetAttribute' => ['our_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'sent_via' => Yii::t('core_model', 'Sent Via'),
            'sent_to' => Yii::t('core_model', 'Sent To') . '*',
            'cid' => Yii::t('core_model', 'Cid'),
            'our_id' => Yii::t('core_model', 'Cur ID'),
            'invite_params' => Yii::t('core_model', 'Invitation parameters'),
        ];
    }

    public function getOur() {
        return $this->hasOne(OrganizationUserRelation::className(), ['id' => 'our_id']);
    }

    public static function getInviteMethods() {
        return [
            'email' => Yii::t('organization_user_relation_invitation', 'Email'),
            'sms' => Yii::t('organization_user_relation_invitation', 'Sms'),
        ];
    }

    // RETURN ARRAY FOR SENT VIA DROPDOWN
    public static function getSentVia() {
        return [
            'email' => Yii::t('quick_payment', 'Email'),
            'sms' => Yii::t('company_user_relation_invitation', 'Sms'),
        ];
    }
}
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

 * @property OrganizationUserRelation $cur
 */

class OrganizationUserRelationInvitation extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'organization_user_relation_invitation';
    }

    public function rules() {
        return [
            [['sent_to'], 'required'],
            [['sent_to'], 'email','message' => Yii::t('core_system', 'The email is not the correct format')],
            [['sent_via'], 'string'],
            [['our_id'], 'integer'],
            [['sent_to'], 'string', 'max' => 256],
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

    public function getCur() {
        return $this->hasOne(OrganizationUserRelation::className(), ['id' => 'our_id']);
    }

    public static function getInviteMethods() {
        return [
            'email' => Yii::t('organization_user_relation_invitation', 'Email'),
            'sms' => Yii::t('organization_user_relation_invitation', 'Sms'),
        ];
    }

}
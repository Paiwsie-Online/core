<?php

namespace common\models;

class OrganizationUserRelationInvitation extends core\OrganizationUserRelationInvitation
{
    public $sent_to_email;
    public $sent_to_mobile;
    public function rules() {
        return [
            [['sent_to'], 'required'],
            ['sent_to_email', 'required', 'when' => function($model){
                return $model->sent_via === 'email' && !isset($model->sent_to);
            }, 'whenClient' => "function (attribute, value){
                return $('#invite-sent_via').val() === 'email'
            }"],
            ['sent_to_mobile', 'required', 'when' => function($model){
                return $model->sent_via === 'sms' && !isset($model->sent_to);
            }, 'whenClient' => "function (attribute, value){
                return $('#invite-sent_via').val() === 'sms'
            }"],
            [['our_id'], 'integer'],
            [['sent_to'], 'string', 'max' => 256],
            [['cid'], 'string', 'max' => 45],
            [['invite_params'], 'string'],
            [['our_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationUserRelation::className(), 'targetAttribute' => ['our_id' => 'id']],
        ];
    }
}
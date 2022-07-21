<?php

namespace common\models;

use common\models\core\Organization;
use common\models\User;
use Yii;

class OrganizationUserRelation extends core\OrganizationUserRelation
{
    public static function getUserLevelOptions() {
        return array(
            'superadmin' => Yii::t('organization_user_relation', 'Superadmin'),
            'cashier' => Yii::t('organization_user_relation', 'Cashier'),
            'admin' => Yii::t('organization_user_relation', 'Admin'),
            'legalGuardian' => Yii::t('organization_user_relation', 'Legal guardian'),
            'user' => Yii::t('organization_user_relation', 'User')
        );
    }
    public function rules() {
        return [
            [['organization_id', 'user_level'], 'required'],
            [['organization_id', 'user_id', 'added_by'], 'integer'],
            [['user_level', 'status'], 'string'],
            [['added', 'status_changed', 'sent_to_email', 'sent_to_mobile'], 'safe'],
            [['title'], 'string', 'max' => 128],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'exist', 'skipOnEmpty'  => true, 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['added_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['added_by' => 'id']],
            [['selected_organization'], 'integer'],
        ];
    }
    public function getUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }
}
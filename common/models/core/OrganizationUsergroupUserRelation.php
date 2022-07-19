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
 * @property int $ou_relation_id
 * @property int $group_id
 * @property int|null $created_by
 * @property int $created_at

 * @property OrganizationUserRelation $ouRelation
 * @property OrganizationUsergroup $group
 * @property User $addedBy
 */

class OrganizationUsergroupUserRelation extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'organization_usergroup_user_relation';
    }

    public function behaviors() {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class,
        ];
    }
    public function rules() {
        return [
            [['ou_relation_id', 'group_id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['ou_relation_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationUserRelation::className(), 'targetAttribute' => ['ou_relation_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationUsergroup::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'ou_relation_id' => Yii::t('core_model', 'User'),
            'group_id' => Yii::t('core_model', 'Group'),
            'created_by' => Yii::t('core_model', 'Added By'),
            'created_at' => Yii::t('core_model', 'Added Time'),
        ];
    }

    public function getOuRelation() {
        return $this->hasOne(OrganizationUserRelation::className(), ['id' => 'ou_relation_id']);
    }

    public function getGroup() {
        return $this->hasOne(OrganizationUsergroup::className(), ['id' => 'group_id']);
    }

    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

}
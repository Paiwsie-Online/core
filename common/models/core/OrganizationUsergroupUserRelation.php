<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property int $id
 * @property int $ou_relation_id
 * @property int $group_id
 * @property int|null $added_by
 * @property string $added

 * @property OrganizationUserRelation $cuRelation
 * @property OrganizationUsergroup $group
 * @property User $addedBy
 */

class OrganizationUsergroupUserRelation extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'organization_usergroup_user_relation';
    }

    public function rules() {
        return [
            [['ou_relation_id', 'group_id', 'added_by'], 'integer'],
            [['added'], 'safe'],
            [['ou_relation_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationUserRelation::className(), 'targetAttribute' => ['ou_relation_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationUsergroup::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['added_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['added_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'ou_relation_id' => Yii::t('core_model', 'User'),
            'group_id' => Yii::t('core_model', 'Group'),
            'added_by' => Yii::t('core_model', 'Added By'),
            'added' => Yii::t('core_model', 'Added Time'),
        ];
    }

    public function getCuRelation() {
        return $this->hasOne(OrganizationUserRelation::className(), ['id' => 'ou_relation_id']);
    }

    public function getGroup() {
        return $this->hasOne(OrganizationUsergroup::className(), ['id' => 'group_id']);
    }

    public function getAddedBy() {
        return $this->hasOne(User::className(), ['id' => 'added_by']);
    }

}
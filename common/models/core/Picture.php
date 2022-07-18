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
 * @property string $uri
 * @property int|null $created_by
 * @property int $created_at
 * @property User $uploadedBy
 * @property User[] $users
 */

class Picture extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'picture';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ],
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules() {
        return [
            [['uri'], 'required'],
            [['uri'], 'string', 'max' => 512],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'uri' => Yii::t('core_model', 'Uri') . '*',
            'created_by' => Yii::t('core_model', 'Uploaded By'),
            'created_at' => Yii::t('core_model', 'Uploaded'),
        ];
    }

    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'uploaded_by']);
    }

    public function getUsers() {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_picture_relation', ['picture_id' => 'id']);
    }

}
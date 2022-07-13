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
 * @property int|null $uploaded_by
 * @property string $uploaded
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
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['uploaded_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['uploaded'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
        ];
    }

    public function rules() {
        return [
            [['uri'], 'required'],
            /*[['uploaded_by'], 'integer'],
            [['uploaded'], 'safe'],*/
            [['uri'], 'string', 'max' => 512],
            [['uploaded_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uploaded_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'uri' => Yii::t('core_model', 'Uri') . '*',
            'uploaded_by' => Yii::t('core_model', 'Uploaded By'),
            'uploaded' => Yii::t('core_model', 'Uploaded'),
        ];
    }

    public function getUploadedBy() {
        return $this->hasOne(User::className(), ['id' => 'uploaded_by']);
    }

    public function getUsers() {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_picture_relation', ['picture_id' => 'id']);
    }

}
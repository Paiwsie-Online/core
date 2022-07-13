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
 * This is the model class for table "graphdata".
 *
 * @property int $id
 * @property string $model
 * @property int $model_id
 * @property string $property
 * @property string|null $value
 * @property string|null $unit
 * @property int|null $created_by
 * @property string|null $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 *
 * @property User $createdBy
 */
class Graphdata extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'graphdata';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['uploaded_by'],
                ],
            ],
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['uploaded_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'model_id', 'property'], 'required'],
            [['model_id', 'created_by', 'updated_by'], 'integer'],
            [['value', 'unit'], 'string'],
            [['updated_at', 'updated_by'], 'safe'],
            [['model'], 'string', 'max' => 512],
            [['property'], 'string', 'max' => 128],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'model' => Yii::t('core_model', 'Model'),
            'model_id' => Yii::t('core_model', 'Model ID'),
            'property' => Yii::t('core_model', 'Property'),
            'value' => Yii::t('core_model', 'Value'),
            'unit' => Yii::t('core_model', 'Unit'),
            'created_by' => Yii::t('core_model', 'Created By'),
            'created_at' => Yii::t('core_model', 'Created At'),
            'updated_by' => Yii::t('core_model', 'Updated By'),
            'updated_at' => Yii::t('core_model', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}

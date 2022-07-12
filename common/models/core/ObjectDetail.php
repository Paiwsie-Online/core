<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * This is the model class for table "object_detail".
 *
 * @property int $object
 * @property string $detail
 * @property string $value
 *
 * @property Objects $object0
 */
class ObjectDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object', 'detail', 'value'], 'required'],
            [['object'], 'integer'],
            [['value'], 'string'],
            [['detail'], 'string', 'max' => 512],
            [['object', 'detail'], 'unique', 'targetAttribute' => ['object', 'detail']],
            [['object'], 'exist', 'skipOnError' => true, 'targetClass' => Objects::className(), 'targetAttribute' => ['object' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'object' => Yii::t('core_model', 'Object'),
            'detail' => Yii::t('core_model', 'Detail'),
            'value' => Yii::t('core_model', 'Value'),
        ];
    }

    /**
     * Gets query for [[Object0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObject0()
    {
        return $this->hasOne(Objects::className(), ['id' => 'object']);
    }
}

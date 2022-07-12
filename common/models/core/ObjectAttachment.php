<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * This is the model class for table "object_attachment".
 *
 * @property int $id
 * @property string $model
 * @property int $model_id
 * @property int $object
 *
 * @property Objects $object0
 */
class ObjectAttachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'model_id', 'object'], 'required'],
            [['model_id', 'object'], 'integer'],
            [['model'], 'string', 'max' => 512],
            [['object'], 'exist', 'skipOnError' => true, 'targetClass' => Objects::className(), 'targetAttribute' => ['object' => 'id']],
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
            'object' => Yii::t('core_model', 'Object'),
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

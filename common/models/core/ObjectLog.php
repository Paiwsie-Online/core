<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * This is the model class for table "object_log".
 *
 * @property int $id
 * @property int $object
 * @property string $data
 * @property string|null $value
 * @property int|null $created_by
 * @property string|null $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 */
class ObjectLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object', 'data'], 'required'],
            [['object', 'created_by', 'updated_by'], 'integer'],
            [['value'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['data'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'object' => Yii::t('core_model', 'Object'),
            'data' => Yii::t('core_model', 'Data'),
            'value' => Yii::t('core_model', 'Value'),
            'created_by' => Yii::t('core_model', 'Created By'),
            'created_at' => Yii::t('core_model', 'Created At'),
            'updated_by' => Yii::t('core_model', 'Updated By'),
            'updated_at' => Yii::t('core_model', 'Updated At'),
        ];
    }
}

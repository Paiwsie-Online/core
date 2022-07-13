<?php

namespace common\models\core;

use Yii;

/**
 * This is the model class for table "organization_detail".
 *
 * @property int $organization_id
 * @property string $detail
 * @property string $value
 *
 * @property Organization $organization
 */
class OrganizationDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'detail', 'value'], 'required'],
            [['organization_id'], 'integer'],
            [['value'], 'string'],
            [['detail'], 'string', 'max' => 128],
            [['organization_id', 'detail'], 'unique', 'targetAttribute' => ['organization_id', 'detail']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'organization_id' => Yii::t('model', 'Organization ID'),
            'detail' => Yii::t('model', 'Detail'),
            'value' => Yii::t('model', 'Value'),
        ];
    }

    /**
     * Gets query for [[Organization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }
}

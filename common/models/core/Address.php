<?php

namespace common\models\core;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property string $address
 * @property int|null $zip_code
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property Enumeration $zipCode
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address';
    }

    public function behaviors() {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address'], 'required'],
            [['address'], 'string'],
            [['zip_code', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['zip_code'], 'exist', 'skipOnError' => true, 'targetClass' => Enumeration::className(), 'targetAttribute' => ['zip_code' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'address' => Yii::t('app', 'Address'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
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

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[ZipCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getZipCode()
    {
        return $this->hasOne(Enumeration::className(), ['id' => 'zip_code']);
    }
}

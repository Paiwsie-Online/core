<?php

namespace common\models\core;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "paiwise_checkout".
 *
 * @property int $id
 * @property string $model
 * @property int $model_id
 * @property float $amount
 * @property string $checkout_id
 * @property string $status
 * @property int|null $status_changed
 * @property string|null $checkout_data
 * @property int|null $created_at
 *
 *
 */
class PaiwiseCheckout extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paiwise_checkout';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'model_id', 'amount', 'checkout_id'], 'required'],
            [['model_id', 'status_changed', 'created_at'], 'integer'],
            [['amount'], 'number'],
            [['status', 'checkout_data'], 'string'],
            [['model'], 'string', 'max' => 512],
            [['checkout_id'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'model_id' => 'Model ID',
            'amount' => 'Amount',
            'checkout_id' => 'Checkout ID',
            'status' => 'Status',
            'status_changed' => 'Status Changed',
            'checkout_data' => 'Checkout Data',
            'created_at' => 'Created At',
        ];
    }

}

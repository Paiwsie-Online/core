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

    public static function checkoutAPICall($data, $url) {
        $apiUrl = Yii::$app->params['paiwiseCheckout']['checkoutURL'] . $url;
        $token = Yii::$app->params['paiwiseCheckout']['bearerToken'];

        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Authorization: Bearer ' . $token]);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // Change to 0 if have to test it in local (change even in Smartadmin API CheckoutController)
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // VERBOSE
        /*
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        $verbose = fopen('php://temp', 'w+');
        curl_setopt($curl, CURLOPT_STDERR, $verbose);
        */
        $curlResponse = curl_exec($curl);
        if ($curlResponse === FALSE) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('An error occurred during curl exec');
        }
        /*
        rewind($verbose);
        $verboseLog = stream_get_contents($verbose);
        echo $verboseLog;
        */
        curl_close($curl);

        //return $curlResponse;
    }
}

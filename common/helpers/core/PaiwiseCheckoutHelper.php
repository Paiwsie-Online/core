<?php

namespace common\helpers\core;

use common\models\core\PaiwiseCheckout;
use Yii;
use yii\web\NotAcceptableHttpException;
use yii\web\ServerErrorHttpException;

class PaiwiseCheckoutHelper
{

    public function checkoutAPICall($data, $url) {
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

    public function create($amount, $currency, $message, $returnUrl, $returnUrlCancel, $model, $model_id, $capture = true) {
        // Array with currency that have to multiply by 100
        $centCurrency = ['EUR', 'SEK', 'USD'];
        if (isset($amount, $currency, $returnUrl, $returnUrlCancel, $model, $model_id)) {
            $metaData = [
                'model' => $model,
                'model_id' => $model_id,
            ];
            if (in_array($currency, $centCurrency)) {
                $dataArr = [
                    'amount' => (int)$amount * 100,
                ];
            } else {
                $dataArr = [
                    'amount' => (int)$amount,
                ];
            }
            $dataArr += [
                'currency' => $currency,
                'message' => $message,
                'capture' => $capture,
                'returnUrl' => $returnUrl,
                'returnUrlCancel' => $returnUrlCancel,
                'metaData' => $metaData,
            ];
            $dataArrEncoded = json_encode($dataArr);
            self::checkoutAPICall($dataArrEncoded, 'create');
            // TODO: Put data in paiwise_checkout table
        } else {
            throw new NotAcceptableHttpException('Missing some data.');
        }
    }

    public function retrieve($cid) {
        if (isset($cid)) {
            $dataArr = [
                'checkout_id' => $cid,
            ];
            $dataArrEncoded = json_encode($dataArr);
            self::checkoutAPICall($dataArrEncoded, 'retrieve');
        } else {
            throw new NotAcceptableHttpException('Missing some data.');
        }
    }

    public function capture() {
        if (isset($cid)) {
            $dataArr = [
                'checkout_id' => $cid,
            ];
            $dataArrEncoded = json_encode($dataArr);
            self::checkoutAPICall($dataArrEncoded, 'capture');
        } else {
            throw new NotAcceptableHttpException('Missing some data.');
        }
    }

    public function refund($cid, $amount, $currency) {
        // Array with currency that have to multiply by 100
        $centCurrency = ['EUR', 'SEK', 'USD'];
        if (isset($cid, $amount)) {
            if (in_array($currency, $centCurrency)) {
                $dataArr = [
                    'amount' => (int)$amount * 100,
                ];
            } else {
                $dataArr = [
                    'amount' => (int)$amount,
                ];
            }
            $dataArr += [
                'checkout_id' => $cid,
            ];
            $dataArrEncoded = json_encode($dataArr);
            self::checkoutAPICall($dataArrEncoded, 'refund');
        } else {
            throw new NotAcceptableHttpException('Missing some data.');
        }
    }
}



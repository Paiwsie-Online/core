<?php

namespace common\helpers\core;

use common\models\core\PaiwiseCheckout;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotAcceptableHttpException;
use yii\web\ServerErrorHttpException;

class PaiwiseCheckoutHelper
{

    public function create() {
        if (isset($_POST)) {
            $centCurrency = ['EUR', 'SEK', 'USD'];
            if (isset($_POST['amount'], $_POST['currency'], $_POST['returnUrl'], $_POST['returnUrlCancel'], $_POST['model'], $_POST['model_id'])) {
                $metaData = [
                    'model' => $_POST['model'],
                    'model_id' => $_POST['model_id'],
                ];
                if (in_array($_POST['currency'], $centCurrency)) {
                    $dataArr = [
                        'amount' => (int)$_POST['amount'] * 100,
                    ];
                } else {
                    $dataArr = [
                        'amount' => (int)$_POST['amount'],
                    ];
                }
                $dataArr += [
                    'currency' => $_POST['currency'],
                    'message' => $_POST['message'] ?? Yii::t('core_system', 'Checkout payment'),
                    'capture' => $_POST['capture'] ?? true,
                    'returnUrl' => $_POST['returnUrl'],
                    'returnUrlCancel' => $_POST['returnUrlCancel'],
                    'metaData' => $metaData,
                ];
                $dataArrEncoded = json_encode($dataArr);
                PaiwiseCheckout::checkoutAPICall($dataArrEncoded, 'create');
            } else {
                throw new NotAcceptableHttpException('Missing some data.');
            }
        } else {
            throw new ServerErrorHttpException('Something went wrong.');
        }
    }

    public function retrieve() {
        if (isset($_POST)) {
            if (isset($_POST['cid'])) {
                $dataArr = [
                    'checkout_id' => $_POST['cid'],
                ];
                $dataArrEncoded = json_encode($dataArr);
                PaiwiseCheckout::checkoutAPICall($dataArrEncoded, 'retrieve');
            } else {
                throw new NotAcceptableHttpException('Missing some data.');
            }
        } else {
            throw new ServerErrorHttpException('Something went wrong.');
        }
    }

    public function capture() {
        if (isset($_POST)) {
            if (isset($_POST['cid'])) {
                $dataArr = [
                    'checkout_id' => $_POST['cid'],
                ];
                $dataArrEncoded = json_encode($dataArr);
                PaiwiseCheckout::checkoutAPICall($dataArrEncoded, 'capture');
            } else {
                throw new NotAcceptableHttpException('Missing some data.');
            }
        } else {
            throw new ServerErrorHttpException('Something went wrong.');
        }
    }

    public function refund() {
        $centCurrency = ['EUR', 'SEK', 'USD'];
        if (isset($_POST)) {
            if (isset($_POST['cid'], $_POST['amount'])) {
                if (in_array($_POST['currency'], $centCurrency)) {
                    $dataArr = [
                        'amount' => (int)$_POST['amount'] * 100,
                    ];
                } else {
                    $dataArr = [
                        'amount' => (int)$_POST['amount'],
                    ];
                }
                $dataArr += [
                    'checkout_id' => $_POST['cid'],
                ];
                $dataArrEncoded = json_encode($dataArr);
                PaiwiseCheckout::checkoutAPICall($dataArrEncoded, 'refund');
            } else {
                throw new NotAcceptableHttpException('Missing some data.');
            }
        } else {
            throw new ServerErrorHttpException('Something went wrong.');
        }
    }
}



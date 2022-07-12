<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class QrController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['generate'],
                'rules' => [
                    [
                        'actions' => ['generate'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'generate' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    public function actionGenerate() {
        if (isset($_GET)) {
            if (isset($_GET['baseUrl'])) {
                $size = isset($_GET['qr_size']) ? $_GET['qr_size'] : 100;
                $margin = isset($_GET['qr_margin']) ? $_GET['qr_margin'] : 10;

                $writer = new PngWriter();
                $data = $_GET['baseUrl'];
                $ignoreArray = ['baseUrl', 'qr_size', 'qr_margin'];
                $counter = 0;
                foreach ($_GET as $key => $value) {
                    if (!in_array($key, $ignoreArray)) {
                        if ($counter === 0) {
                            $data.='?';
                        } else {
                            $data.='&';
                        }
                        $data.=$key.'='.$value;
                        $counter++;
                    }
                }
                $qrCode = QrCode::create($data)
                    ->setEncoding(new Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                    ->setSize($size)
                    ->setMargin($margin)
                    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                    ->setForegroundColor(new Color(0, 0, 0))
                    ->setBackgroundColor(new Color(255, 255, 255));
                $result = $writer->write($qrCode);
                header('Content-Type: '.$result->getMimeType());
                echo $result->getString();
            } else {
                echo "missing GET variable baseUrl";
            }

        }
    }

}
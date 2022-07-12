<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace api\controllers\core;

use api\components\core\BaseController;
use common\models\core\ApiKey;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

class ActiveController extends BaseController {

    public $params;
    public $apiKey;

    public function beforeAction($action)
    {
        $hasAccess = false;
        if (!parent::beforeAction($action)) {
            $hasAccess = false;
        }
        /*Check API key*/
        $authHeader = Yii::$app->request->headers['Authorization'];
        $pattern = '/^Bearer\s+(.*?)$/';
        if (preg_match($pattern, $authHeader, $matches)) {
            $authHeader = $matches[1];
            $apiKeyKey = ApiKey::find()->where(['key' => $authHeader])->one();
            if ($apiKeyKey) {
                if (!$apiKeyKey['expiry_date'] || ($apiKeyKey['expiry_date'] && date('Y-m-d') <= $apiKeyKey['expiry_date'])) {
                    $this->apiKey = $apiKeyKey;
                    $hasAccess = true;
                    $this->params = Yii::$app->request->bodyParams;
                } elseif ($apiKeyKey['expiry_date'] && date('Y-m-d') >= $apiKeyKey['expiry_date']) {
                    throw new ForbiddenHttpException("The key you used has expired");
                }
            }
        } else {
            $hasAccess = false;
        }
        if ($hasAccess) {
            return true;
        }
        throw new ForbiddenHttpException("You do not have permission to do this action");
    }

    public function checkMissingParams($requiredParams) {
        $missingParams = [];
        foreach ($requiredParams as $required) {
            if (!isset($this->params["{$required}"])) {
                $missingParams[] = $required;
            }
        }
        if (count($missingParams) !== 0) {
            throw new BadRequestHttpException("Missing parameters: ".implode(', ', $missingParams), 23);
        }
        return true;
    }

    public function getBaseUrl($instance) {
        switch ($instance) {
            // TODO: get this from config
            case 'naildemocracy':
                return 'https://naildemocracy.paiwise.com';                 //Live
                //return 'https://naildemocracyadv.backend.test';           //Local
            default :
                return 'https://smartadmin.paiwise.com';                    //Live
                //return 'https://smartadminadv.backend.test';              //Local
        }
    }

}
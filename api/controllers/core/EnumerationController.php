<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace api\controllers\core;

use api\components\core\BaseController;
use common\models\core\Enumeration;
use yii\filters\auth\HttpBearerAuth;

class EnumerationController extends BaseController {

    public $systemTime;
    public $modelClass = Enumeration::class;

    public function behaviors() {
        $behaviors = parent::behaviors();
        // Tells that we use the authenticator only for this operations
        $behaviors['authenticator']['only'] = ['index', 'view'];
        // Set the auth mode to bearer (access token)
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];
        return $behaviors;
    }

    protected function verbs() {
        $verbs = parent::verbs();
        $verbs =  [
            'index' => ['GET', 'POST', 'HEAD'],
        ];
        return $verbs;
    }

    // CHANGE DATA PROVIDER OF THE INDEX ACTION IN CASE OF SPECIFIED TYPE
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = function($action)
        {
            if (isset($_GET['enumerator'])) {
                return new \yii\data\ActiveDataProvider([
                    'query' => Enumeration::find()->where(['enumerator' => $_GET['enumerator']]),
                    'pagination' => [
                        'pageSizeLimit' => [0,100],
                    ]
                ]);
            }
            return new \yii\data\ActiveDataProvider([
                'query' => Enumeration::find(),
                'pagination' => [
                    'pageSizeLimit' => [0,100],
                ]
            ]);
        };

        return $actions;
    }


}
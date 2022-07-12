<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace api\controllers\core;

use api\components\core\BaseController;
use common\models\core\Graphdata;
use yii\filters\auth\HttpBearerAuth;

class GraphdataController extends BaseController {

    public $systemTime;
    public $modelClass = Graphdata::class;

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
            if (isset($_GET['type'])) {
                return new \yii\data\ActiveDataProvider([
                    'query' => Graphdata::find()->where(['type' => $_GET['type']]),
                    'pagination' => [
                        'pageSizeLimit' => [0,100],
                    ]
                ]);
            }
            return new \yii\data\ActiveDataProvider([
                'query' => Graphdata::find(),
                'pagination' => [
                    'pageSizeLimit' => [0,100],
                ]
            ]);
        };

        return $actions;
    }


}
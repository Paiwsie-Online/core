<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use Yii;
use common\models\core\Cronjob;
use yii\web\NotFoundHttpException;

class CronjobController extends BaseController {

    // THE CRONJOB CANT HAVE ACCESS CONTROL. IN THE FUTURE FILTER BY IP
    /*public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException("You do not have permission to do this action");
                },
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }*/

    protected function findModel($id) {
        if (($model = Cronjob::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist.'));
    }

}
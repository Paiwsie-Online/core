<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\SystemLog;
use common\models\core\SystemLogSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class SystemLogController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view'],
                'denyCallback' => function($rule, $action){
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => isset(Yii::$app->user->identity),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->hasAccess('siteAdmin', 'read') || Yii::$app->user->identity->hasAccess('systemAdmin', 'read')) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET']
                ],
            ],
        ];

    }

    public function actionIndex() {
        $searchModel = new SystemLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id) {
        if (($model = SystemLog::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist'));
    }

}
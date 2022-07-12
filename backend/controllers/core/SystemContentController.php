<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\SystemContent;
use common\models\core\SystemContentSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class SystemContentController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'update'],
                'denyCallback' => function ($rule, $action) {
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
                    [
                        'actions' => ['update'],
                        'allow' => isset(Yii::$app->user->identity),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->hasAccess('siteAdmin', 'update') || Yii::$app->user->identity->hasAccess('systemAdmin', 'update')) {
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
                    'view' => ['GET'],
                    'update' => ['GET', 'POST', 'PUT', 'PATCH'],
                ],
            ]
        ];
    }

    public function actionIndex() {
        //Scan through content and add site content if non-existing
        $systemContents = SystemContent::findAll(['instance' => 'default']);
        foreach ($systemContents as $systemContent) {
            $siteContent = SystemContent::findOne(['instance' => Yii::$app->params['default_site_settings']['instance'], 'content' => $systemContent->content]);
            if (!$siteContent) {
                $newSiteContent = new SystemContent();
                $newSiteContent->instance = Yii::$app->params['default_site_settings']['instance'];
                $newSiteContent->content = $systemContent->content;
                $newSiteContent->value = $systemContent->value;
                $newSiteContent->save();
            }
        }
        $searchModel = new SystemContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($instance, $content) {
        return $this->render('view', [
            'model' => $this->findModel($instance, $content),
        ]);
    }

    public function actionUpdate($instance, $content) {
        $model = $this->findModel($instance, $content);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'instance' => $model->instance, 'content' => $model->content]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    protected function findModel($instance, $content) {
        if (($model = SystemContent::findOne(['instance' => $instance, 'content' => $content])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist'));
    }

}
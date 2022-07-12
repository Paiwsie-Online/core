<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\Enumeration;
use common\models\core\EnumerationSearch;
use common\models\core\SystemLog;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class EnumerationController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'update'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/login');
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
                    [
                        'actions' => ['create', 'newenumerator'],
                        'allow' => isset(Yii::$app->user->identity),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->hasAccess('siteAdmin', 'create') || Yii::$app->user->identity->hasAccess('systemAdmin', 'create')) {
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
        $systemEnumerations = Enumeration::find()->all();
        $searchModel = new EnumerationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new Enumeration();
        if ($model->load(Yii::$app->request->post())) {
            $model->parent = (Yii::$app->request->post()['parentId'] !== '' ? (int)Yii::$app->request->post()['parentId'] : null);
            $model->save();
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' created enumeration';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' created enumeration: ' . $model->id;
            $dataFormat = [
                'event' =>  'createdEnumeration',
                'user'  =>  Yii::$app->user->identity->id,
                'enumeration' => $model->id,
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect('index');
    }

    // TO CREATE A NEW TYPE/CATEGORY FOR ENUMERATION
    public function actionNewenumerator() {
        $this->layout = false;
        return $this->render('modal-view');
    }

    // SEARCH PARENTS (AJAX)
    public function actionSearchParents() {
        $parents = Enumeration::find()->andWhere(['like', 'value', $_POST['value']])->all();
        $array = [];
        if (!empty($parents)) {
            foreach ($parents as $parent) {
                $array[$parent->id] = $parent->value;
            }
        }
        return json_encode($array);
    }

    /**
     * @return mixed
     */
    // ACTION UPDATE VALUE (AJAX)
    public function actionUpdateValue() {
        $model = $this->findModel((int)$_POST['enumId']);
        $model->value = $_POST['name'];
        $model->save();
        $systemLog = new SystemLog();
        $systemLog->saveSystemLog('changed organization style', 'changed organization style (enumeration) ' . $_POST['enumId'] . ' to: ' . $_POST['name']);
    }


    protected function findModel($id) {
        if (($model = Enumeration::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist'));
    }

}
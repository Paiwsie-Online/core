<?php

namespace backend\controllers\core;

use Yii;
use common\models\core\UserNotificationRelation;
use common\models\core\UserNotificationRelationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserNotificationRelationController implements the CRUD actions for UserNotificationRelation model.
 */
class UserNotificationRelationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserNotificationRelation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserNotificationRelationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserNotificationRelation model.
     * @param integer $notification_id
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($notification_id, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($notification_id, $user_id),
        ]);
    }

    /**
     * Creates a new UserNotificationRelation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserNotificationRelation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'notification_id' => $model->notification_id, 'user_id' => $model->user_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserNotificationRelation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $notification_id
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($notification_id, $user_id)
    {
        $model = $this->findModel($notification_id, $user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'notification_id' => $model->notification_id, 'user_id' => $model->user_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserNotificationRelation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $notification_id
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($notification_id, $user_id)
    {
        $this->findModel($notification_id, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserNotificationRelation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $notification_id
     * @param integer $user_id
     * @return UserNotificationRelation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($notification_id, $user_id)
    {
        if (($model = UserNotificationRelation::findOne(['notification_id' => $notification_id, 'user_id' => $user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

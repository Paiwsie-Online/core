<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\UserLogin;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;


class UserLoginController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['continue-session'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['continue-session'],
                        'allow' => isset(Yii::$app->user->identity),
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'continue-session' => ['GET', 'POST', 'PUT', 'PATCH'],
                ],
            ],
        ];
    }

    protected function findModel($id): ?UserLogin {
        if (($model = UserLogin::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCheckUserSessionCookie() {
        if (!isset(Yii::$app->request->cookies['userSession']) && isset(Yii::$app->user->identity)) {
            $this->redirect(['/site/logout']);
        }
    }

    public function actionContinueSession() {
        if (isset(Yii::$app->session->isActive)) {
            $userLoginSession = UserLogin::find()->where(['user_id' => Yii::$app->user->identity->id, 'session_id' => Yii::$app->session->id])->orderBy('logged DESC')->one();
            if (!$userLoginSession) {
                throw new NotFoundHttpException(\sprintf('User with id %s not found', Yii::$app->user->identity->id));
            }
            $timeNow = new \DateTime('now', new \DateTimeZone(Yii::$app->params['defaults']['systemTimeZone']));
            $timeNowUTC = $timeNow->getTimestamp();
            $sessionTimeout = Yii::$app->params['systemTimeout']['authTimeout'];
            if (($timeNowUTC - $userLoginSession->created_at) > $sessionTimeout) {
                $userLoginSession->expire = $timeNowUTC + $sessionTimeout;
                $userLoginSession->save();
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

}
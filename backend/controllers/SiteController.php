<?php

namespace backend\controllers;

use common\models\core\LoginForm;
use common\models\core\SystemLog;
use common\models\core\UserLogin;
use Yii;
use yii\web\Cookie;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SiteController extends core\SiteController
{

    public function actionSelectOrganization ()
    {
        $this->layout = Yii::$app->params['layout']['authentication'];
        return $this->render('select-organization');
    }

    public function actionLoginemail() {
        $this->layout = Yii::$app->params['layout']['authentication'];
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (Yii::$app->params['loginOptions']['allowEmail'] === true) {
            $model = new LoginForm();
            $model->scenario = 'login';
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->load(Yii::$app->request->post())) {
                if (isset($model->user)) {
                    $model->user->email = strtolower($model->user->email);
                    if ($model->user && $model->user->email_status === 'verified') {
                        if ($model->login()) {
                            return $this->redirect(['site/select-organization']);
                        }
                    } else {
                        Yii::$app->session->setFlash('danger', Yii::t('core_system', 'Your email is not correct or has not been verified yet!'));
                    }
                } else {
                    Yii::$app->session->setFlash('danger', Yii::t('core_system', 'Invalid credentials!'));
                }
            }
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        if (Yii::$app->params['loginOptions']['allowPhone'] === true) {
            return $this->redirect(['site/login-mobile']);
        }
        if (Yii::$app->params['loginOptions']['allowQR'] === true) {
            return $this->redirect(['site/loginqr']);
        }
        $message = Yii::t('core_system', 'Something went wrong when getting the page, plase try again');
        $_SESSION['message'] = $message;
        return $this->redirect(['/site/sysmes']);
    }

}
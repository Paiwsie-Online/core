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
    public function actionCreateTeam ()
    {
        $this->layout = "core/system_message";
        return $this->render('create-team');
    }

    public function actionCreateAssoc ()
    {
        $this->layout = Yii::$app->params['layout']['authentication'];
        return $this->render('create-assoc');
    }

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
                            $systemLog = new SystemLog();
                            $systemLog->user_id = Yii::$app->user->identity->id;
                            $systemLog->instance = Yii::$app->user->identity->instance;
                            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' logged in';
                            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' logged in using Email: ' . ($model->email ?? 'Error!') . ' for this instance ' . Yii::$app->user->identity->instance . ' from ip: ' . Yii::$app->request->getUserIP();
                            $dataFormat = [
                                'event' => 'login',
                                'user' => Yii::$app->user->identity->id,
                                'method' => 'email',
                                'ip' => Yii::$app->request->getUserIP(),
                            ];
                            $systemLog->data_format = json_encode($dataFormat);
                            $systemLog->save();
                            $userLogin = new UserLogin();
                            $userLogin->user_id = Yii::$app->user->identity->id;
                            $userLogin->ip = Yii::$app->request->getUserIP();
                            $timeNow = new \DateTime('now', new \DateTimeZone(Yii::$app->params['defaults']['systemTimeZone']));
                            $timeNowUTC =  $timeNow->getTimestamp();
                            $userLogin->expire = $timeNowUTC + Yii::$app->params['systemTimeout']['authTimeout'];
                            $userLogin->session_logged = $timeNowUTC;
                            $userLogin->session_id = Yii::$app->session->id;
                            $userLogin->save();
                            if (isset(Yii::$app->request->cookies['userSession'])) {
                                $cookies = Yii::$app->response->cookies;
                                unset($cookies['userSession']);
                            }
                            $userSessionCookie = new Cookie([
                                'name' => 'userSession',
                                'value' => '1',
                                'httpOnly' => false,
                            ]);
                            Yii::$app->response->cookies->add($userSessionCookie);
                            Yii::$app->cache->flush();
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
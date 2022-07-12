<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\SystemLog;
use common\models\core\SystemSetting;
use common\models\core\UserLogin;
use common\models\core\UserSetting;
use Yii;
use yii\filters\AccessControl;
use yii\web\Cookie;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\core\LoginForm;
use common\models\core\ContactForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SiteController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['error', 'index', 'about', 'contact', 'loginqr', 'loginemail', 'login', 'get-organization-invite', 'systeminfo', 'logout', 'test-mode', 'sysmes', 'export-pdf', 'login-mobile'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginemail');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['index', 'logout', 'about', 'contact', 'systeminfo', 'test-mode'],
                        'allow' => isset(Yii::$app->user->identity),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['loginqr', 'loginemail', 'login', 'login-mobile'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['error', 'sysmes', 'get-organization-invite'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['export-pdf'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->hasAccess('digitalAccount', 'read');
                        },
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'error' => ['GET', 'POST'],
                    'index' => ['GET', 'POST'],
                    'loginemail' => ['GET', 'POST'],
                    'login-mobile' => ['GET', 'POST'],
                    'loginqr' => ['GET', 'POST'],
                    'login' => ['GET', 'POST'],
                    'logout' => ['GET', 'POST'],
                    'systeminfo' => ['GET'],
                    'get-organization-invite' => ['GET', 'POST'],
                    'invite-access' => ['GET', 'POST'],
                    'test-mode' => ['GET', 'POST'],
                    'about' => ['GET'],
                    'contact' => ['GET', 'POST'],
                    'sysmes' => ['GET'],
                    'export-pdf' => ['GET'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'timezone' => [
                'class' => 'yii2mod\timezone\TimezoneAction',
            ],
        ];
    }

    public function actionError() {
        $exception = Yii::$app->getErrorHandler()->exception;
        return $this->render('/error/' . $exception->statusCode, ['exception' => $exception]);
    }

    // HOME PAGE
    public function actionIndex($start = null, $end = null) {
        $datesArrayOptionValues = SystemSetting::getOptionsDates();
        $thisMonthDecoded = json_decode($datesArrayOptionValues[1]['value']);
        $defaultStart = $thisMonthDecoded->start;
        $defaultEnd = $thisMonthDecoded->end;
        if (isset($_POST) && !empty($_POST)) {
            if ($_POST['time'] !== 'other') {
                $time = json_decode($_POST['time']);
            } else {
                if ($_POST['start'] <= $_POST['end']) {
                    $start = $_POST['start'];
                    $end = $_POST['end'];
                } else {
                    Yii::$app->session->setFlash('danger', Yii::t('core_system', 'Please check dates and try again!'));
                }
            }
            return $this->redirect(['index', 'start' => ($time->start ?? ($start ?? $defaultStart)), 'end' => ($time->end ?? ($end ?? $defaultEnd))]);
        }
        // Array with dates
        $dates = [];
        $current = strtotime(($start ?? $defaultStart));
        $last = strtotime(($end ?? $defaultEnd));
        while ($current <= $last) {
            $dates[] = [date('Y-m-d', $current), 0];
            $current = strtotime('+1 day', $current);
        }
        // First day
        $timeArray = ($start ?? $defaultStart);

        $type = (isset($_SESSION['testMode']) && $_SESSION['testMode'] === false ? 'live' : 'test');
        return $this->render('index', [
            'type' => $type,
            'dates' => $dates,
            'timeArray' => $timeArray,
            'datesArrayValues' => $datesArrayOptionValues,
        ]);
    }

    // CHECK IF DEFAULT LOGIN IS WITH EMAIL OR QR CODE
    public function actionLoginqr() {
        $this->layout = Yii::$app->params['layout']['authentication'];
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (Yii::$app->params['loginOptions']['allowQR'] === true) {
            return $this->render('loginqr');
        }
        if (Yii::$app->params['loginOptions']['allowEmail'] === true) {
            return $this->redirect(['site/loginemail']);
        }
        $message = Yii::t('core_system', 'Something went wrong when getting the page, plase try again');
        $_SESSION['message'] = $message;
        return $this->redirect(['/site/sysmes']);
    }

    // LOGIN WITH EMAIL
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
                            return $this->goBack();
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

    // LOGIN WITH MOBILE
    public function actionLoginMobile() {
        $this->layout = Yii::$app->params['layout']['authentication'];
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (Yii::$app->params['loginOptions']['allowPhone'] === true) {
            $model = new LoginForm();
            $model->scenario = 'loginMobile';
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->load(Yii::$app->request->post())) {
                if (isset($model->user)) {
                    $model->user->phone = strtolower($model->user->phone);
                    if ($model->user && $model->user->phone_status === 'verified') {
                        if ($model->loginMobile()) {
                            $systemLog = new SystemLog();
                            $systemLog->user_id = Yii::$app->user->identity->id;
                            $systemLog->instance = Yii::$app->user->identity->instance;
                            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' logged in';
                            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' logged in using Phone: ' . ($model->phone ?? 'Error!') . ' from ip: ' . Yii::$app->request->getUserIP();
                            $dataFormat = [
                                'event' => 'login',
                                'user' => Yii::$app->user->identity->id,
                                'method' => 'phone',
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
                            return $this->goBack();
                        }
                    } else {
                        Yii::$app->session->setFlash('danger', Yii::t('core_system', 'Your phone is not correct or has not been verified yet!'));
                    }
                } else {
                    Yii::$app->session->setFlash('danger', Yii::t('core_system', 'Invalid credentials!'));
                }
            }
            $model->password = '';
            return $this->render('login-mobile', [
                'model' => $model,
            ]);
        }
        if (Yii::$app->params['loginOptions']['allowEmail'] === true) {
            return $this->redirect(['site/loginemail']);
        }
        if (Yii::$app->params['loginOptions']['allowQR'] === true) {
            return $this->redirect(['site/loginqr']);
        }
        $message = Yii::t('core_system', 'Something went wrong when getting the page, plase try again');
        $_SESSION['message'] = $message;
        return $this->redirect(['/site/sysmes']);
    }

    // ??
    public function actionLogin() {
        $this->layout = Yii::$app->params['layout']['authentication'];
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (Yii::$app->params['loginOptions']['allowQR'] === true && Yii::$app->params['loginOptions']['default'] === 'qr') {
            if (Yii::$app->params['loginOptions']['allowEmail'] === false) {
                return $this->render('loginqr');
            }
            return $this->redirect(['site/loginqr']);
        }
        if (Yii::$app->params['loginOptions']['allowEmail'] === true) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $message = Yii::t('core_system', 'Something went wrong when getting the page, please try again');
        $_SESSION['message'] = $message;
        return $this->redirect(['/site/sysmes']);
    }

    // LOGOUT
    public function actionLogout() {
        $userLoginSession = UserLogin::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['logged' => SORT_DESC])->one();
        if (!$userLoginSession){
            throw new NotFoundHttpException(\sprintf('User with id: %s not found ', Yii::$app->user->identity->id));
        }
        $systemLog = new SystemLog();
        $systemLog->user_id = Yii::$app->user->identity->id;
        $systemLog->instance = Yii::$app->user->identity->instance;
        $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' logged out';
        $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' logged out for this instance ' . Yii::$app->user->identity->instance . ' from ip: ' . Yii::$app->request->getUserIP();
        $dataFormat = [
            'event' => 'logout',
            'user' => Yii::$app->user->identity->id,
            'ip' => Yii::$app->request->getUserIP(),
        ];
        $systemLog->data_format = json_encode($dataFormat);
        $systemLog->save();
        if (isset(Yii::$app->request->cookies['userSession'])) {
            $cookies = Yii::$app->response->cookies;
            unset($cookies['userSession']);
            Yii::$app->cache->flush();
        }
        Yii::$app->user->logout();
        return $this->goHome();
    }

    // CONTACT PAGE
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    // CHECK IF THERE IS A ORGANIZATION INVITE
    public function actionGetOrganizationInvite($cid) {
        $this->layout = Yii::$app->params['layout']['systemMessage'];
        if (!isset($_SESSION['organizationInvites'][$cid])) {
            $_SESSION['organizationInvites'][$cid] = true;
        }
        if (isset(Yii::$app->user->identity)) {
            return $this->goHome();
        } else {
            return $this->render('invite-access');
        }
    }

    // ABOUT PAGE
    public function actionAbout() {
        return $this->render('about');
    }

    // SYSTEM INFO PAGE
    public function actionSysteminfo() {
        return $this->render('systeminfo');
    }

    // TEST MODE PAGE
    public function actionTestMode() {
        return $this->render('test-mode');
    }

    // SYSTEM MESSAGE PAGE
    public function actionSysmes() {
        $this->layout = Yii::$app->params['layout']['systemMessage'];
        return $this->render('/site/sysmes');
    }

    // SETTING WHEEL IN LIST AND INDEX PAGES
    public function actionSettingsWheel($setting) {
        $organization = Yii::$app->user->identity->selectedOrganization->id;
        $userSettings = UserSetting::findOne(['user_id' => Yii::$app->user->identity->id, 'setting' => $setting]);
        if (isset($userSettings)) {
            $uSValueDecoded = json_decode($userSettings->value);
        }
        if (!empty($_POST)) {
            $array = [];
            $i = 0;
            foreach ($_POST as $item) {
                $i++;
                $array[] = $item;
            }
            $finalArray = [
                $organization => $array,
            ];
            
            if (isset($userSettings, $uSValueDecoded)) {
                $uSValueDecoded->{$organization} = $array;
                $userSettings->value = json_encode($uSValueDecoded);
                $userSettings->save();
            } else {
                $newUserSettings = new UserSetting();
                $newUserSettings->user_id = Yii::$app->user->identity->id;
                $newUserSettings->setting = $setting;
                $newUserSettings->value = json_encode($finalArray);
                $newUserSettings->save();
            }
            return $this->redirect((Yii::$app->request->referrer ?? Yii::$app->homeUrl));
        }
        // var added to prevent errors, in future will use similar code as the commented code above
        $columns = [];
        $this->layout = false;
        return $this->render('/site/modal-settings-columns', [
            'columns' => $columns,
        ]);
    }

    // AJAX SAVE USER HAVE A BLOCK VISIBLE OR NOT
    public static function actionDashboardBlockVisible() {
        $organization = Yii::$app->user->identity->selectedOrganization->id;
        $model = UserSetting::findOne(['user_id' => Yii::$app->user->identity->id, 'setting' => 'DashBoardBlock' . $_POST['block'] . 'Visible']);
        if (!isset($model)) {
            $model = new UserSetting();
        }
        $model->user_id = Yii::$app->user->identity->id;
        $model->setting = 'DashBoardBlock' . $_POST['block'] . 'Visible';
        $valueDecoded = json_decode($model->value);
        $valueArray = [$_POST['block'] => $_POST['visible']];
        if (isset($valueDecoded)) {
            $valueDecoded->$organization = $valueArray;
            $model->value = json_encode($valueDecoded);
        } else {
            $array = [
                Yii::$app->user->identity->selectedOrganization->id => $valueArray,
            ];
            $model->value = json_encode($array);
        }
        $model->save();
    }

}

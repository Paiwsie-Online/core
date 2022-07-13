<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\LoginForm;
use common\models\core\SystemLog;
use common\models\core\User;
use common\models\core\UserSearch;
use common\models\core\UserSetting;
use Imagine\Image\ManipulatorInterface;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UserController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'set-testmode', 'view', 'register', 'verify', 'emailsent', 'profile', 'profile-settings', 'forgotpw', 'resetpw', 'pwchange', 'addemailpw', 'addemail', 'resend-verification-email', 'emailchange', 'addtagid', 'mergeaccounts', 'merge-accounts-confirm', 'register-mobile', 'verify-sms', 'forgotpw-mobile', 'add-mobilepw', 'add-mobile', 'resend-verification-mobile', 'phone-change'],
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
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
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
                        'actions' => ['set-testmode'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->selectedOrganization->kyc === 'approved') {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['register', 'emailsent', 'forgotpw', 'resetpw', 'register-mobile', 'forgotpw-mobile'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['verify', 'verify-sms'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['profile', 'profile-settings', 'pwchange', 'addemailpw', 'addemail', 'resend-verification-email', 'emailchange', 'addtagid', 'mergeaccounts', 'merge-accounts-confirm', 'add-mobilepw', 'add-mobile', 'resend-verification-mobile', 'phone-change'],
                        'allow' => isset(Yii::$app->user->identity),
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                    'set-testmode' => ['GET', 'POST'],
                    'view' => ['GET'],
                    'register' => ['GET', 'POST'],
                    'verify' => ['GET'],
                    'emailsent' => ['GET'],
                    'profile' => ['GET'],
                    'profile-settings' => ['GET', 'POST'],
                    'forgotpw' => ['GET', 'POST'],
                    'resetpw' => ['GET', 'POST'],
                    'pwchange' => ['GET', 'POST'],
                    'addemailpw' => ['GET', 'POST'],
                    'addemail' => ['GET', 'POST'],
                    'resend-verification-email' => ['GET', 'POST'],
                    'emailchange' => ['GET', 'POST'],
                    'addtagid' => ['GET', 'POST'],
                    'mergeaccounts' => ['GET', 'POST'],
                    'merge-accounts-confirm' => ['GET', 'POST'],
                    'register-mobile' => ['GET', 'POST'],
                    'verify-sms' => ['GET'],
                    'forgotpw-mobile' => ['GET', 'POST'],
                    'add-mobilepw' => ['GET', 'POST'],
                    'add-mobile' => ['GET', 'POST'],
                    'resend-verification-mobile' => ['GET', 'POST'],
                    'phone-change' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    // INDEX PAGE
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // FRONTEND USERS PAGE
    public function actionFrontendUsers() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchFrontendUsers(Yii::$app->request->queryParams);
        return $this->render('frontend-users', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // ACTION CHANGE TEST MODE
    public function actionSetTestmode() {
        if ($_POST['value'] === 'true') {
            $_SESSION['userSetTestMode'] = true;
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' entered test mode';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' entered test mode';
            $dataFormat = [
                'event' => 'testmode',
                'user' => Yii::$app->user->identity->id,
                'value' => 'entered',
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();

        } else {
            if (isset($_SESSION['userSetTestMode'])) {
                unset($_SESSION['userSetTestMode']);
            }
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' exited test mode';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' exited test mode';
            $dataFormat = [
                'event' => 'testmode',
                'user' => Yii::$app->user->identity->id,
                'value' => 'exited',
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
        }
        return $this->goHome();
    }

    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    // REGISTER EMAIL PAGE
    public function actionRegister() {
        $this->layout = Yii::$app->params['layout']['authentication'];
        $model = new User();
        $model->scenario = 'registration';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->email = strtolower($model->email);
            $model->email_status = 'unverified';
            $model->first_name = ucwords($model->first_name);
            $model->last_name = ucwords($model->last_name);
            if ($model->temp_password == $model->retype_password) {
                $model->cid = md5(($model->email . uniqid('', true)));
                $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->temp_password);
            }
            //$model->registered = $this->systemTime;
            $model->auth_key = \Yii::$app->security->generateRandomString();
            $model->access_token = \Yii::$app->security->generateRandomString();
            $model->instance = \Yii::$app->params['default_site_settings']['instance'];
            if ($model->save()) {
                $systemLog = new SystemLog();
                $systemLog->user_id = $model->id;
                $systemLog->instance = $model->instance;
                $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' registered';
                $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' registered from ip: ' . Yii::$app->request->getUserIP();
                $dataFormat = [
                    'event' => 'registered',
                    'user' => $model->id,
                    'ip' => Yii::$app->request->getUserIP(),
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
                $this->sendVerificationLink($model);
                return $this->redirect(['emailsent', 'type' => 'email', 'method' => 'email']);
            }
            $message = Yii::t('core_user', 'Registration failed! Please contact <a href="mailto:{email}">{email}</a> and send the error message below.', ['email' => Yii::$app->params['default_site_settings']['support_email']]) . '<br>';
            $message .= Html::errorSummary($model);
            $_SESSION['message'] = $message;

            return $this->redirect(['/site/sysmes']);
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    // REGISTER MOBILE PAGE
    public function actionRegisterMobile() {
        $this->layout = Yii::$app->params['layout']['authentication'];
        $model = new User();
        $model->scenario = 'registrationMobile';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->phone_status = 'unverified';
            $model->first_name = ucwords($model->first_name);
            $model->last_name = ucwords($model->last_name);
            if ($model->temp_password == $model->retype_password) {
                $model->cid = md5(($model->phone . uniqid('', true)));
                $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->temp_password);
            }
            $model->registered = $this->systemTime;
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->access_token = Yii::$app->security->generateRandomString();
            $model->instance = Yii::$app->params['default_site_settings']['instance'];
            if ($model->save()) {
                $systemLog = new SystemLog();
                $systemLog->user_id = $model->id;
                $systemLog->instance = $model->instance;
                $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' registered (mobile)';
                $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' registered (mobile) from ip: ' . Yii::$app->request->getUserIP();
                $dataFormat = [
                    'event' => 'registeredMobile',
                    'user' => $model->id,
                    'ip' => Yii::$app->request->getUserIP(),
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
                $this->sendVerificationLinkMobile($model);
                return $this->redirect(['emailsent', 'type' => 'phone', 'method' => 'sms']);
            }
            $message = Yii::t('core_user', 'Registration failed! Please contact <a href="mailto:{email}">{email}</a> and send the error message below.', ['email' => Yii::$app->params['default_site_settings']['support_email']]) . '<br>';
            $message .= Html::errorSummary($model);
            $_SESSION['message'] = $message;

            return $this->redirect(['/site/sysmes']);
        }
        return $this->render('register-mobile', [
            'model' => $model,
        ]);
    }

    // RETURN USER MODEL
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist'));
    }

    // VERIFY EMAIL PAGE
    public function actionVerify($cid) {
        $model = User::find()->where(['cid' => $cid])->one();
        $message = '<div class="site-index text-center">
                            ' . Yii::t('core_user', '<h4>Verification failed!</h4>
                        <strong>Verification code {cid} cannot be found or is invalid.</strong><br>Please contact the support for further information!<br>E-mail: <a href="mailto:{support_email}">{support_email}</a><br><i>If you have previously verified your email, you can ignore this message and login.</i>', ['cid' => $cid, 'support_email' => Yii::$app->params['default_site_settings']['support_email']]) . '<br>' . Html::a(Yii::t('core_system', 'Login'), '/site/loginemail', ['class' => 'btn btn-primary mt-4']) . '
                        </div>';
        if ($model) {
            if ($model->email_status) {
                if ($model->email_status === 'verified') {
                    $message = '<div class="site-index text-center">
                            ' . Yii::t('core_user', '<h4>This email has already been verified!</h4>Click the button below to continue to the login page') . '<br>' . Html::a(Yii::t('core_system', 'Login'), '/site/loginemail', ['class' => 'btn btn-primary mt-4']) . '
                        </div>';
                } else {
                    $model->email_status = 'verified';
                    if ($model->save()) {
                        $systemLog = new SystemLog();
                        $systemLog->user_id = $model->id;
                        $systemLog->instance = $model->instance;
                        $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' verified email';
                        $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' verified email from ip: ' . Yii::$app->request->getUserIP();
                        $dataFormat = [
                            'event' => 'verified',
                            'user' => $model->id,
                            'ip' => Yii::$app->request->getUserIP(),
                        ];
                        $systemLog->data_format = json_encode($dataFormat);
                        $systemLog->save();
                        if (Yii::$app->params['loginOptions']['allowEmail'] == true) {
                            $message = '<div class="site-index text-center">
                            ' . Yii::t('core_user', '<h4>Thank you for verifying your email address!</h4>
                        You may now login using your email.') . '<br>' . Html::a(Yii::t('core_system', 'Go to login'), '/site/loginemail', ['class' => 'btn btn-primary mt-4']) . '
                        </div>';
                        } else {
                            $message = '<div class="site-index text-center">
                            ' . Yii::t('core_user', '<h4>Thank you for verifying your email address!</h4>
                        <br>Your email has been added to your profile successfully.') . '<br>' . Html::a(Yii::t('core_system', 'Continue'), '/site/index', ['class' => 'btn btn-primary mt-4']) . '
                        </div>';
                        }
                        $this->sendVerificationEmail($model);
                    } else {
                        $message = '<div class="site-index text-center">
                            ' . Yii::t('core_user', '<h4>Verification failed!</h4>
                        Unfortunitely your email verification failed, we are now sending you another verification link.<br>If the error persists please contact <a href="mailto:{support_email}">{support_email}</a> and send the error message below.', ['support_email' => Yii::$app->params['default_site_settings']['support_email']]) . '<br>' . Html::a(Yii::t('core_system', 'Index'), '/site/loginemail', ['class' => 'btn btn-primary mt-4']) . '
                        </div>';
                        $message .= Html::errorSummary($model);
                        $this->sendRepeatVerificationLink($model);
                        $this->layout = Yii::$app->params['layout']['authentication'];
                        $_SESSION['message'] = $message;
                        return $this->redirect(['/site/sysmes']);
                    }
                }
            }
        }
        $this->layout = Yii::$app->params['layout']['authentication'];
        $_SESSION['message'] = $message;
        return $this->redirect(['/site/sysmes']);
    }

    // VERIFY SMS PAGE
    public function actionVerifySms($cid) {
        $model = User::find()->where(['cid' => $cid])->one();
        $message = '<div class="site-index text-center">
                            ' . Yii::t('core_user', '<h4>Verification failed!</h4>
                        <strong>Verification code {cid} cannot be found or is invalid.</strong><br>Please contact the support for further information!<br>E-mail: <a href="mailto:{support_email}">{support_email}</a><br><i>If you have previously verified your email, you can ignore this message and login.</i>', ['cid' => $cid, 'support_email' => Yii::$app->params['default_site_settings']['support_email']]) . '<br>' . Html::a(Yii::t('core_system', 'Login'), '/site/login-mobile', ['class' => 'btn btn-primary mt-4']) . '
                        </div>';
        if ($model) {
            if ($model->phone_status) {
                if ($model->phone_status === 'verified') {
                    $message = '<div class="site-index text-center">
                            ' . Yii::t('core_user', '<h4>This email has already been verified!</h4>Click the button below to continue to the login page') . '<br>' . Html::a(Yii::t('core_system', 'Login'), '/site/loginemail', ['class' => 'btn btn-primary mt-4']) . '
                        </div>';
                } else {
                    $model->phone_status = 'verified';
                    if ($model->save()) {
                        $systemLog = new SystemLog();
                        $systemLog->user_id = $model->id;
                        $systemLog->instance = $model->instance;
                        $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' verified phone';
                        $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' verified phone from ip: ' . Yii::$app->request->getUserIP();
                        $dataFormat = [
                            'event' => 'verified',
                            'user' => $model->id,
                            'ip' => Yii::$app->request->getUserIP(),
                        ];
                        $systemLog->data_format = json_encode($dataFormat);
                        $systemLog->save();
                        if (Yii::$app->params['loginOptions']['allowPhone'] == true) {
                            $message = '<div class="site-index text-center">
                            ' . Yii::t('core_user', '<h4>Thank you for verifying your phone!</h4>
                        You may now login using your phone.') . '<br>' . Html::a(Yii::t('core_system', 'Go to login'), '/site/login-mobile', ['class' => 'btn btn-primary mt-4']) . '
                        </div>';
                        } else {
                            $message = '<div class="site-index text-center">
                            ' . Yii::t('core_user', '<h4>Thank you for verifying your phone!</h4>
                        <br>Your phone has been added to your profile successfully.') . '<br>' . Html::a(Yii::t('core_system', 'Continue'), '/site/index', ['class' => 'btn btn-primary mt-4']) . '
                        </div>';
                        }
                        $this->sendVerificationSms($model);
                    } else {
                        $message = '<div class="site-index text-center">
                            ' . Yii::t('core_user', '<h4>Verification failed!</h4>
                            Unfortunitely your phone verification failed, we are now sending you another verification link.<br>If the error persists please contact <a href="mailto:{support_email}">{support_email}</a> and send the error message below.', ['support_email' => Yii::$app->params['default_site_settings']['support_email']]) . '<br>' . Html::a(Yii::t('core_system', 'Index'), '/site/login-mobile', ['class' => 'btn btn-primary mt-4']) . '
                        </div>';
                        $message .= Html::errorSummary($model);
                        $this->sendRepeatVerificationLinkSms($model);
                        $this->layout = Yii::$app->params['layout']['authentication'];
                        $_SESSION['message'] = $message;
                        return $this->redirect(['/site/sysmes']);
                    }
                }
            }
        }
        $this->layout = Yii::$app->params['layout']['authentication'];
        $_SESSION['message'] = $message;
        return $this->redirect(['/site/sysmes']);
    }

    // SEND EMAIL
    public function actionEmailsent($type, $method) {
        $this->layout = Yii::$app->params['layout']['authentication'];
        $message = '<div class="site-index text-center">' .
            Yii::t('core_user', '<h4>Thank you for registering to {site_name}!</h4>
                        <br>A verification {method} has been sent to the {type} provided by you. <br> Please click on the verification link in the {method}. <br>After your {type} has been verified you may login!', ['site_name' => (Yii::$app->params['default_site_settings']['site_name'] ?? 'SmartAdmin'), 'type' => $type, 'method' => $method]) . '<br>' . Html::a(Yii::t('core_system', 'Continue'), '/site/loginemail', ['class' => 'btn btn-primary mt-4']) . '
                    </div>';
        $_SESSION['message'] = $message;
        return $this->redirect(['/site/sysmes']);
    }

    // PROFILE PAGE
    public function actionProfile($id = null) {
        if ($id === null) {
            $id = Yii::$app->user->identity->id;
        }
        $model = $this->findModel($id);
        return $this->render('profile', array(
            'model' => $model
        ));
    }

    // PROFILE SETTINGS PAGE
    public function actionProfileSettings($id = null) {
        if ($id === null) {
            $id = Yii::$app->user->identity->id;
        }
        $model = $this->findModel($id);
        return $this->render('profile-settings', array(
            'model' => $model
        ));
    }

    // FORGOT PASSWORD EMAIL PAGE
    public function actionForgotpw() {
        $this->layout = Yii::$app->params['layout']['authentication'];
        if (Yii::$app->request->post()) {
            $email = strtolower(Yii::$app->request->post('email'));
            $model = User::findOne(['email' => $email, 'instance' => Yii::$app->params['default_site_settings']['instance']]);
            if (isset($model->email_status) && $model->email_status === 'verified') {
                $model->scenario = 'pwreset';
                $hash = md5($model->email . '_' . $model->cid);
                $userSettingCheck = UserSetting::findOne(['setting' => 'pwResetTime', 'user_id' => $model->id]);
                if (!isset($userSettingCheck)) {
                    $userSetting = new UserSetting();
                    $userSetting->user_id = $model->id;
                    $userSetting->setting = 'pwResetTime';
                    $userSetting->value = (string)$this->systemTime;
                    $userSetting->save();
                } else {
                    $userSettingCheck->value = (string)$this->systemTime;
                    $userSettingCheck->save();
                }
                $model->temp_password = $model->retype_password = '123Abc';
                if ($model->save()) {
                    $systemLog = new SystemLog();
                    $systemLog->user_id = $model->id;
                    $systemLog->instance = $model->instance;
                    $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' email sent for reset password';
                    $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' email sent for reset password from ip: ' . Yii::$app->request->getUserIP();
                    $dataFormat = [
                        'event' => 'emailSentResetPw',
                        'user' => $model->id,
                        'ip' => Yii::$app->request->getUserIP(),
                    ];
                    $systemLog->data_format = json_encode($dataFormat);
                    $systemLog->save();
                    $this->sendPasswordReset($model, $hash);
                    $message = '<div class="site-index text-center">' .
                        Yii::t('core_user', 'An email has been sent to {email} with a link to reset your password!<br>Check your inbox (the spam folder as well) and follow the link in the email, on the page that opens, type in your new password. Once your new password has been saved you can use it to log in to your account.<br>The link will be valid for 2 hours from now.', ['email' => $email]) . '<br>' . Html::a(Yii::t('core_system', 'Continue'), '/site/loginemail', ['class' => 'btn btn-primary mt-4']) . '
                                </div>';
                    $_SESSION['message'] = $message;
                    return $this->redirect(['/site/sysmes']);
                }
            } else {
                if (isset($model->email_status) && $model->email_status === 'unverified') {
                    $message = '<div class="site-index text-center">' .
                        Yii::t('core_user', 'The email you provided: {email} is not yet verified!<br>Password reset is not possible. Find the orignal verification email you have received and click on the verification link first to activate your account.', ['email' => $email]) . '<br>' . Html::a(Yii::t('core_user', 'Back to Forgot Password'), '/user/forgotpw', ['class' => 'btn btn-primary mt-4']) . '
                                </div>';
                } else {
                    $message = '<div class="site-index text-center">' .
                        Yii::t('core_user', 'The email you provided: {email} is not in our database!<br>Password reset is not possible. Check for spelling errors and re-type it.', ['email' => $email]) . '<br>' . Html::a(Yii::t('core_user', 'Back to Forgot Password'), '/user/forgotpw', ['class' => 'btn btn-primary mt-4']) . '
                                </div>';
                }
                $_SESSION['message'] = $message;
                return $this->redirect(['/site/sysmes']);
            }
        }
        return $this->render('forgotpw');
    }

    // FORGOT PASSWORD PHONE PAGE
    public function actionForgotpwMobile() {
        $this->layout = Yii::$app->params['layout']['authentication'];
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            $model = User::findOne(['phone' => $model->phone, 'instance' => Yii::$app->params['default_site_settings']['instance']]);
            if (isset($model->phone_status) && $model->phone_status === 'verified') {
                $model->scenario = 'pwreset2';
                $hash = md5($model->phone . '_' . $model->cid);
                $userSettingCheck = UserSetting::findOne(['setting' => 'pwResetTime', 'user_id' => $model->id]);
                if (!isset($userSettingCheck)) {
                    $userSetting = new UserSetting();
                    $userSetting->user_id = $model->id;
                    $userSetting->setting = 'pwResetTime';
                    $userSetting->value = (string)$this->systemTime;
                    $userSetting->save();
                } else {
                    $userSettingCheck->value = (string)$this->systemTime;
                    $userSettingCheck->save();
                }
                $model->temp_password = $model->retype_password = '123Abc';
                if ($model->save()) {
                    $systemLog = new SystemLog();
                    $systemLog->user_id = $model->id;
                    $systemLog->instance = $model->instance;
                    $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' sms sent for reset password';
                    $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' sms sent for reset password from ip: ' . Yii::$app->request->getUserIP();
                    $dataFormat = [
                        'event' => 'smsSentResetPw',
                        'user' => $model->id,
                        'ip' => Yii::$app->request->getUserIP(),
                    ];
                    $systemLog->data_format = json_encode($dataFormat);
                    $systemLog->save();
                    $this->sendPasswordResetSms($model, $hash);
                    $message = '<div class="site-index text-center">' .
                        Yii::t('core_user', 'An sms has been sent to {phone} with a link to reset your password!<br>Follow the link in the sms, on the page that opens, type in your new password. Once your new password has been saved you can use it to log in to your account.<br>The link will be valid for 2 hours from now.', ['phone' => $model->phone]) . '<br>' . Html::a(Yii::t('core_system', 'Continue'), '/site/login-mobile', ['class' => 'btn btn-primary mt-4']) . '
                                </div>';
                    $_SESSION['message'] = $message;
                    return $this->redirect(['/site/sysmes']);
                }
            } else {
                if (isset($model->phone_status) && $model->phone_status === 'unverified') {
                    $message = '<div class="site-index text-center">' .
                        Yii::t('core_user', 'The phone you provided: {phone} is not yet verified!<br>Password reset is not possible. Find the orignal verification sms you have received and click on the verification link first to activate your account.', ['phone' => $model->phone]) . '<br>' . Html::a(Yii::t('core_user', 'Back to Forgot Password'), '/user/forgotpw-mobile', ['class' => 'btn btn-primary mt-4']) . '
                                </div>';
                } else {
                    $message = '<div class="site-index text-center">' .
                        Yii::t('core_user', 'The phone you provided: {phone} is not in our database!<br>Password reset is not possible. Check for spelling errors and re-type it.', ['phone' => $model->phone]) . '<br>' . Html::a(Yii::t('core_user', 'Back to Forgot Password'), '/user/forgotpw-mobile', ['class' => 'btn btn-primary mt-4']) . '
                                </div>';
                }
                $_SESSION['message'] = $message;
                return $this->redirect(['/site/sysmes']);
            }
        }
        return $this->render('forgotpw-mobile', ['model' => $model]);
    }

    // RESET PASSWORD PAGE
    public function actionResetpw($id = null, $hash = null) {
        $this->layout = Yii::$app->params['layout']['authentication'];
        $model = $this->findModel($id);
        if (isset($model)) {
            $model->scenario = (isset($model->email) ? 'pwreset' : 'pwreset2');
            $userSetting = UserSetting::findOne(['user_id' => $model->id, 'setting' => 'pwResetTime']);
            if (isset($userSetting)) {
                $type = ($model->email ?? $model->phone);
                $localHash = md5($type . '_' . $model->cid);
                $DBTime = strtotime($userSetting->value);
                $localTime = strtotime($this->systemTime);
                $diff = ($localTime - $DBTime) / 60;
                if ($localHash === $hash && $diff < 120) {
                    if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
                    }
                    if ($model->load(Yii::$app->request->post())) {
                        if (isset($model->temp_password)) {
                            $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->temp_password);
                        }
                        if ($model->save()) {
                            $systemLog = new SystemLog();
                            $systemLog->user_id = $model->id;
                            $systemLog->instance = $model->instance;
                            $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' reset the account password';
                            $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' reset the password from ip: ' . Yii::$app->request->getUserIP();
                            $dataFormat = [
                                'event' => 'resetPw',
                                'user' => $model->id,
                                'ip' => Yii::$app->request->getUserIP(),
                            ];
                            $systemLog->data_format = json_encode($dataFormat);
                            $systemLog->save();
                            $userSetting->delete();
                            $message = '<div class="site-index text-center">' .
                                Yii::t('core_user', 'You have successfully re-set your password. You may now login with the new password!') . '<br>' . Html::a(Yii::t('core_system', 'Continue'), (isset($model->email) ? '/site/loginemail' : '/site/login-mobile'), ['class' => 'btn btn-primary mt-4']) . '
                                        </div>';
                            $_SESSION['message'] = $message;
                            return $this->redirect(['/site/sysmes']);
                        }
                    } else {
                        return $this->render('resetpw', [
                            'model' => $model,
                        ]);
                    }
                } else {
                    $message = '<div class="site-index text-center">' .
                        Yii::t('core_user', 'The password reset security code is either invalid or it has timed out! <br>Please try resetting your password again.<br>If the problem persists do not hesitate to contact the support for further information! <br> E-mail: <a href="mailto:{support_email}">{support_email}</a>', ['support_email' => Yii::$app->params['default_site_settings']['support_email']]) . '<br>' . Html::a(Yii::t('core_system', 'Continue'), (isset($model->email) ? '/site/loginemail' : '/site/login-mobile'), ['class' => 'btn btn-primary mt-4']) . '
                                </div>';
                    $_SESSION['message'] = $message;
                    return $this->redirect(['/site/sysmes']);
                }
            } else {
                $message = '<div class="site-index text-center">' .
                    Yii::t('core_system', 'This password reset link has already been used! You cannot use it twice.<br>If you still need to reset your password you must request a new link.<br>Please contact the support for further information! <br>E-mail: <a href="mailto:{support_email}">{support_email}</a>', ['support_email' => Yii::$app->params['default_site_settings']['support_email']]) . '<br>' . Html::a(Yii::t('core_system', 'Continue'), (isset($model->email) ? '/site/loginemail' : '/site/login-mobile'), ['class' => 'btn btn-primary mt-4']) . '
                            </div>';
                $_SESSION['message'] = $message;
                return $this->redirect(['/site/sysmes']);
            }
        } else {
            $message = '<div class="site-index text-center">' .
                Yii::t('core_user', 'User not found or the password reset link is invalid!') . '<br>' . Html::a(Yii::t('core_system', 'Continue'), (isset($model->email) ? '/site/loginemail' : '/site/login-mobile'), ['class' => 'btn btn-primary mt-4']) . '
                        </div>';
            $_SESSION['message'] = $message;
            return $this->redirect(['/site/sysmes']);
        }
    }

    // CHANGE PASSWORD PAGE
    public function actionPwchange($id = null) {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $model->scenario = 'pwchange';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->temp_password == $model->retype_password && $model->retype_password !== $model->old_password) {
                $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->temp_password);
                $model->old_password = $model->temp_password;
                if ($model->save()) {
                    $systemLog = new SystemLog();
                    $systemLog->user_id = $model->id;
                    $systemLog->instance = $model->instance;
                    $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' changed the password';
                    $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' changed the password from ip: ' . Yii::$app->request->getUserIP();
                    $dataFormat = [
                        'event' => 'changePw',
                        'user' => $model->id,
                        'ip' => Yii::$app->request->getUserIP(),
                    ];
                    $systemLog->data_format = json_encode($dataFormat);
                    $systemLog->save();
                    Yii::$app->session->setFlash('success', Yii::t('core_user', 'Your password has been changed successfully'));
                    return $this->redirect(['profile']);
                }
            }
            if ($model->temp_password == $model->retype_password && $model->old_password == $model->retype_password) {
                Yii::$app->session->setFlash('danger', Yii::t('core_user', 'Your new password can not be the same as the old password'));
                return $this->redirect(['pwchange']);
            }
        } else {
            return $this->render('pwchange', [
                'model' => $model,
            ]);
        }
    }

    // ADD EMAIL AND PASSWORD PAGE
    public function actionAddemailpw($id = null) {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $model->scenario = 'addemailpw';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->temp_password === $model->retype_password) {
                $model->email_status = 'unverified';
                $model->email = strtolower($model->email);
                $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->temp_password);
                if ($model->save()) {
                    $this->sendVerificationAddedEmail($model);
                    $systemLog = new SystemLog();
                    $systemLog->user_id = $model->id;
                    $systemLog->instance = $model->instance;
                    $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' added email and password';
                    $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' added email: ' . $model->email . ' and password from ip: ' . Yii::$app->request->getUserIP();
                    $dataFormat = [
                        'event' => 'addEmailPw',
                        'user' => $model->id,
                        'email' => $model->email,
                        'ip' => Yii::$app->request->getUserIP(),
                    ];
                    $systemLog->data_format = json_encode($dataFormat);
                    $systemLog->save();
                    Yii::$app->session->setFlash('success', Yii::t('core_user', 'Email and password has been added successfully'));
                    return $this->redirect(['profile']);
                }
            }
        }
        return $this->render('addemailpw', [
            'model' => $model,
        ]);
    }

    // ADD PHONE AND PASSWORD PAGE
    public function actionAddMobilepw($id = null) {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $model->scenario = 'addphonepw';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->temp_password === $model->retype_password) {
                $model->phone_status = 'unverified';
                $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->temp_password);
                if ($model->save()) {
                    $this->sendVerificationAddedPhone($model);
                    $systemLog = new SystemLog();
                    $systemLog->user_id = $model->id;
                    $systemLog->instance = $model->instance;
                    $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' added phone and password';
                    $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' added phone: ' . $model->phone . ' and password from ip: ' . Yii::$app->request->getUserIP();
                    $dataFormat = [
                        'event' => 'addMobilePw',
                        'user' => $model->id,
                        'phone' => $model->phone,
                        'ip' => Yii::$app->request->getUserIP(),
                    ];
                    $systemLog->data_format = json_encode($dataFormat);
                    $systemLog->save();
                    Yii::$app->session->setFlash('success', Yii::t('core_user', 'Phone and password has been added successfully'));
                    return $this->redirect(['profile-settings']);
                }
            }
        }
        return $this->render('add-mobilepw', [
            'model' => $model,
        ]);
    }

    // ADD EMAIL PAGE
    public function actionAddemail($id = null) {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $model->scenario = 'addemail';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->email = strtolower($model->email);
            $model->email_status = 'unverified';
            if ($model->save()) {
                $this->sendVerificationAddedEmail($model);
                $systemLog = new SystemLog();
                $systemLog->user_id = $model->id;
                $systemLog->instance = $model->instance;
                $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' added email';
                $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' added email: ' . $model->email . ' from ip: ' . Yii::$app->request->getUserIP();
                $dataFormat = [
                    'event' => 'addEmail',
                    'user' => $model->id,
                    'email' => $model->email,
                    'ip' => Yii::$app->request->getUserIP(),
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
                Yii::$app->session->setFlash('success', Yii::t('core_user', 'Email has been added successfully'));
                return $this->redirect(['profile']);
            }
        }
        return $this->render('addemail', [
            'model' => $model,
        ]);
    }

    // ADD PHONE PAGE
    public function actionAddMobile($id = null) {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $model->scenario = 'addphone';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->phone_status = 'unverified';
            if ($model->save()) {
                $this->sendVerificationAddedPhone($model);
                $systemLog = new SystemLog();
                $systemLog->user_id = $model->id;
                $systemLog->instance = $model->instance;
                $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' added phone';
                $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' added phone: ' . $model->phone . ' from ip: ' . Yii::$app->request->getUserIP();
                $dataFormat = [
                    'event' => 'addedPhone',
                    'user' => $model->id,
                    'phone' => $model->phone,
                    'ip' => Yii::$app->request->getUserIP(),
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
                Yii::$app->session->setFlash('success', Yii::t('core_user', 'Phone has been added successfully'));
                return $this->redirect(['profile-settings']);
            }
        }
        return $this->render('add-mobile', [
            'model' => $model,
        ]);
    }

    // ACTION RESEND VERIFICATION EMAIL
    public function actionResendVerificationEmail($id = null) {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $this->sendVerificationChangeEmailLink($model);
        $systemLog = new SystemLog();
        $systemLog->user_id = $model->id;
        $systemLog->instance = $model->instance;
        $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' resend verification email';
        $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' resend verification email: ' . $model->email . ' from ip: ' . Yii::$app->request->getUserIP();
        $dataFormat = [
            'event' => 'resendEmail',
            'user' => $model->id,
            'email' => $model->email,
            'ip' => Yii::$app->request->getUserIP(),
        ];
        $systemLog->data_format = json_encode($dataFormat);
        $systemLog->save();
        Yii::$app->session->setFlash('success', Yii::t('core_user', 'Verification Email was sent'));
        return $this->redirect(['profile']);
    }

    // ACTION RESEND VERIFICATION PHONE
    public function actionResendVerificationMobile($id = null) {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $this->sendVerificationChangeMobileLink($model);
        $systemLog = new SystemLog();
        $systemLog->user_id = $model->id;
        $systemLog->instance = $model->instance;
        $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' resend verification sms';
        $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' resend verification sms: ' . $model->phone . ' from ip: ' . Yii::$app->request->getUserIP();
        $dataFormat = [
            'event' => 'resendSms',
            'user' => $model->id,
            'phone' => $model->phone,
            'ip' => Yii::$app->request->getUserIP(),
        ];
        $systemLog->data_format = json_encode($dataFormat);
        $systemLog->save();
        Yii::$app->session->setFlash('success', Yii::t('core_user', 'Verification Phone was sent'));
        return $this->redirect(['profile-settings']);
    }

    // CHANGE EMAIL PAGE
    public function actionEmailchange($id = null) {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $model->scenario = 'echange';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->old_password) {
                $model->email = strtolower($model->email);
                $model->email_status = 'unverified';
                if ($model->save()) {
                    $this->sendVerificationChangeEmailLink($model);
                    $systemLog = new SystemLog();
                    $systemLog->user_id = $model->id;
                    $systemLog->instance = $model->instance;
                    $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' changed email';
                    $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' changed email: ' . $model->email . ' from ip: ' . Yii::$app->request->getUserIP();
                    $dataFormat = [
                        'event' => 'changeEmail',
                        'user' => $model->id,
                        'email' => $model->email,
                        'ip' => Yii::$app->request->getUserIP(),
                    ];
                    $systemLog->data_format = json_encode($dataFormat);
                    $systemLog->save();
                    Yii::$app->session->setFlash('success', Yii::t('core_user', 'Email has been changed successfully'));
                    return $this->redirect(['profile']);
                }
            }
        }
        return $this->render('emailchange', [
            'model' => $model,
        ]);
    }

    // CHANGE PHONE PAGE
    public function actionPhoneChange($id = null) {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $model->scenario = 'pchange';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->old_password) {
                $model->phone_status = 'unverified';
                if ($model->save()) {
                    $this->sendVerificationChangeMobileLink($model);
                    $systemLog = new SystemLog();
                    $systemLog->user_id = $model->id;
                    $systemLog->instance = $model->instance;
                    $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' changed phone';
                    $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' changed phone: ' . $model->phone . ' from ip: ' . Yii::$app->request->getUserIP();
                    $dataFormat = [
                        'event' => 'changedPhone',
                        'user' => $model->id,
                        'phone' => $model->phone,
                        'ip' => Yii::$app->request->getUserIP(),
                    ];
                    $systemLog->data_format = json_encode($dataFormat);
                    $systemLog->save();
                    Yii::$app->session->setFlash('success', Yii::t('core_user', 'Phone has been changed successfully'));
                    return $this->redirect(['profile-settings']);
                }
            }
        }
        return $this->render('phone-change', [
            'model' => $model,
        ]);
    }

    // ADD TAGID PAGE
    public function actionAddtagid() {
        $model = $this->findModel(Yii::$app->user->identity->id);
        return $this->render('addtagid', [
            'model' => $model,
        ]);
    }

    // MERGE ACCOUNTS PAGE
    public function actionMergeaccounts() {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $secondAccountLogin = new LoginForm();
        if (!isset($_SESSION['secondMergeAccount']) || $_SESSION['secondMergeAccount'] === null) {
            $secondAccount = null;
            if ($secondAccountLogin->load(Yii::$app->request->post())) {
                if ($secondAccountLogin->user) {
                    $secondAccount = $secondAccountLogin->user;
                    $_SESSION['secondAccount'] = $secondAccount->cid;
                }
            }
        } else {
            $secondAccount = User::findOne(['cid' => $_SESSION['secondMergeAccount']]);
            unset($_SESSION['secondMergeAccount']);
            $_SESSION['secondAccount'] = $secondAccount->cid;
        }
        return $this->render('mergeaccounts', [
            'model' => $model,
            'secondAccount' => $secondAccount,
            'secondAccountLogin' => $secondAccountLogin
        ]);
    }

    // ACTION CONFIRM MERGE ACCOUNT
    public function actionMergeAccountsConfirm(int $mergeInto) {
        if (isset($_SESSION['secondAccount'])) {
            $sessionAccount = User::findOne(['cid' => $_SESSION['secondAccount']]);
            if ($sessionAccount) {
                if ($mergeInto === 1) {
                    $mergeIntoAccount = $sessionAccount;
                    $mergeFromAccount = User::findOne(['id' => Yii::$app->user->identity->id]);
                } elseif ($mergeInto === 2) {
                    $mergeIntoAccount = User::findOne(['id' => Yii::$app->user->identity->id]);
                    $mergeFromAccount = $sessionAccount;
                }
                if (isset($mergeIntoAccount, $mergeFromAccount)) {
                    if (User::mergeAccounts($mergeIntoAccount, $mergeFromAccount)) {
                        Yii::$app->session->setFlash('success', Yii::t('core_user', 'Your accounts merged successfully'));
                        $this->redirect('/site/index');
                    }
                }
            }
        } else {
            $this->layout = Yii::$app->params['layout']['authentication'];
            $message = '<div class="site-index text-center">' .
                Yii::t('core_system', 'Something went wrong when merging your account<br>Please try again!') . '<br>' . Html::a(Yii::t('core_system', 'Go Back'), '/site/index', ['class' => 'btn btn-primary mt-4']) . '
                            </div>';
            $_SESSION['message'] = $message;
            return $this->redirect(['/site/sysmes']);
        }
    }

    // SEND VERIFIED EMAIL
    protected function sendVerificationEmail($model) {
        $message = $this->getMailHeader();
        $message .= Yii::t('core_email', '<p><b>Dear {first_name} {last_name}</b>,</p><p style="margin-top:10px;">Your email address: {email} has been verified. You may now login to the site.<br><a href="{link}">go to login</a></p>', ['first_name' => $model->first_name, 'last_name' => $model->last_name, 'email' => $model->email, 'link' => Yii::$app->params['default_site_settings']['base_url'] . '/site/loginemail']);
        $message .= $this->getMailSignature();
        $subject = Yii::t('core_email', 'Email address verified');
        return $this->sendMail($message, $subject, $model->email);
    }

    // SEND VERIFIED SMS
    protected function sendVerificationSms($model) {
        $message = Yii::t('core_email', 'Your phone: {phone} has been verified. You may now login to the site. {link}', ['phone' => $model->phone, 'link' => Yii::$app->params['default_site_settings']['base_url'] . '/site/login-mobile']);
        Yii::$app->sms->sendSms($model->phone, $message);
    }

    // SEND FOR VERIFY EMAIL
    private function sendVerificationLink(User $model) {
        $message = $this->getMailHeader();
        $message .= Yii::t('core_email', '<p><b>Dear {first_name} {last_name}</b>, <br>Thank you for registering to {site_name}. </p><p style="margin-top:10px;">In order to complete your registration you must verify your registered email address, please click on the verification link below.</p><a href="{link}">Verify your email address</a>', ['first_name' => $model->first_name, 'last_name' => $model->last_name, 'link' => Yii::$app->params['default_site_settings']['base_url'] . '/user/verify?cid=' . $model->cid, 'site_name' => (Yii::$app->params['default_site_settings']['site_name'] ?? 'SmartAdmin')]);
        $message .= $this->getMailSignature();
        $subject = Yii::t('core_email', 'Verify your email address');
        return $this->sendMail($message, $subject, $model->email);
    }

    // SEND FOR VERIFY SMS
    private function sendVerificationLinkMobile(User $model) {
        $message = Yii::t('core_email', 'Thank you for registering to {site_name}. To complete your registration please click on the link. {link}', ['link' => Yii::$app->params['default_site_settings']['base_url'] . '/user/verify-sms?cid=' . $model->cid, 'site_name' => (Yii::$app->params['default_site_settings']['site_name'] ?? 'SmartAdmin')]);
        Yii::$app->sms->sendSms($model->phone, $message);
    }

    // SEND VERIFICATION FOR CHANGE EMAIL
    private function sendVerificationChangeEmailLink(User $model) {
        $message = $this->getMailHeader();
        $message .= Yii::t('core_email', '<p><b>Dear {first_name} {last_name}</b>,</p> <p style="margin-top:10px;">Thank you for change your email.<br>Please click on the verification link below.<br><a href="{link}">Verify your email address</a></p>', ['first_name' => $model->first_name, 'last_name' => $model->last_name, 'link' => Yii::$app->params['default_site_settings']['base_url'] . '/user/verify?cid=' . $model->cid, 'site_name' => (Yii::$app->params['default_site_settings']['site_name'] ?? 'SmartAdmin')]);
        $message .= $this->getMailSignature();
        $subject = Yii::t('core_email', 'Verify your email address');
        return $this->sendMail($message, $subject, $model->email);
    }

    // SEND VERIFICATION FOR CHANGE PHONE
    private function sendVerificationChangeMobileLink(User $model) {
        $message = Yii::t('core_email', 'Thank you for change your phone. Please click on the verification link. {link}', ['link' => Yii::$app->params['default_site_settings']['base_url'] . '/user/verify-sms?cid=' . $model->cid]);
        Yii::$app->sms->sendSms($model->phone, $message);
    }

    // SEND REPEAT VERIFICATION EMAIL
    private function sendRepeatVerificationLink(User $model) {
        $message = $this->getMailHeader();
        $message .= Yii::t('core_email', '<p><b>Dear {first_name} {last_name}</b>,</p> <p style="margin-top:10px;">Thank you for your patience, we hope this link will work better for you.<br>If the problem persists, please do not hesitate to contact our support.<br><a href="{link}">Verify your email address</a></p>', ['first_name' => $model->first_name, 'last_name' => $model->last_name, 'link' => Yii::$app->params['default_site_settings']['base_url'] . '/user/verify?cid=' . $model->cid]);
        $message .= $this->getMailSignature();
        $subject = Yii::t('core_email', 'Verify your email address');
        return $this->sendMail($message, $subject, $model->email);
    }

    // SEND REPEAT VERIFICATION SMS
    private function sendRepeatVerificationLinkSms(User $model) {
        $message = Yii::t('core_email', 'Thank you for your patience, we hope this link will work better for you. If the problem persists, please contact our support. {link}', ['link' => Yii::$app->params['default_site_settings']['base_url'] . '/user/verify-sms?cid=' . $model->cid]);
        Yii::$app->sms->sendSms($model->phone, $message);
    }

    // SEND VERIFIED ADDED EMAIL
    private function sendVerificationAddedEmail(User $model) {
        $message = $this->getMailHeader();
        $message .= Yii::t('core_email', '<p><b>Dear {first_name} {last_name}</b>, <br>Thank you for adding your email address to your account. </p><p style="margin-top:10px;">In order for your email to be added correctly to your account it has to be verified, please click on the verification link below.<br><a href="{link}">Verify your email address</a></p>', ['first_name' => $model->first_name, 'last_name' => $model->last_name, 'link' => Yii::$app->params['default_site_settings']['base_url'] . '/user/verify?cid=' . $model->cid]);
        $message .= $this->getMailSignature();
        $subject = Yii::t('core_email', 'Verify your email address');
        return $this->sendMail($message, $subject, $model->email);
    }

    // SEND VERIFIED ADDED PHONE
    private function sendVerificationAddedPhone(User $model) {
        $message = Yii::t('core_email', 'Thank you for adding your phone to your account. To add your phone correctly to your account click on the verification link {link}', ['link' => Yii::$app->params['default_site_settings']['base_url'] . '/user/verify-sms?cid=' . $model->cid]);
        Yii::$app->sms->sendSms($model->phone, $message);
    }

    // SEND PASSWORD RESET EMAIL
    protected function sendPasswordReset($model, $hash) {
        $message = $this->getMailHeader();
        $message .= Yii::t('core_email', '<p><b>Dear {first_name} {last_name}</b>,<br>You have initiated a password reset request.</p><p style="margin-top:10px;">In order to complete, you must click on the following link then type and save the new password on the page that loads.<br><a href="{link}">Reset your password</a></p>', ['first_name' => $model->first_name, 'last_name' => $model->last_name, 'link' => Yii::$app->params['default_site_settings']['base_url'] . '/user/resetpw?id=' . $model->id . '&hash=' . $hash]);
        $message .= $this->getMailSignature();
        $subject = Yii::t('core_email', 'Password reset requested');
        return $this->sendMail($message, $subject, $model->email);
    }

    // SEND PASSWORD RESET SMS
    protected function sendPasswordResetSms($model, $hash) {
        $message = Yii::t('core_email', 'You have initiated a password reset request. Click on the following link to create a new password {link}', ['link' => Yii::$app->params['default_site_settings']['base_url'] . '/user/resetpw?id=' . $model->id . '&hash=' . $hash]);
        Yii::$app->sms->sendSms($model->phone, $message);
    }

    // GET HEADER EMAIL
    private function getMailHeader() {
        return '<h2 style="text-align: center"><img src="' . Yii::$app->thumbnailer->get(Yii::$app->params['default_site_settings']['base_url'] . Yii::$app->params['branding']['lightLogo'], 30, 30, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) . '" style="max-height:30px"> ' . (Yii::$app->params['default_site_settings']['site_name'] ?? 'SmartAdmin') . '</h2>';
    }

    // GET SIGNATURE EMAIL
    private function getMailSignature() {
        return '<table style="width: 100%; margin-top:30px">
            <tr>
                <td><p><i>This is an automatically generated message, please do not reply to this email.<br>If you wish to send us a message, please, use the contact form on the website</i><p></td>
            </tr>
            <tr><td style="height:20px;"></td></tr>
            <tr>
                <th><b>Kind regards,</b></th>
            </tr>
            <tr>
                <td>Administration</td>
            </tr>
            <tr>
                <td>' . (Yii::$app->params['default_site_settings']['site_name'] ?? 'SmartAdmin') . '</td>
            </tr>
        </table>';
    }

    // ACTION SEND EMAIL
    private function sendMail($message, $subject, $email) {
        Yii::$app->mailer->compose()
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setTo($email)
            ->setSubject($subject)
            ->setTextBody($message)
            ->setHtmlBody($message)
            ->send();
        return 'OK';
    }

}
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\Picture;
use common\models\core\SystemLog;
use common\models\core\UserLogin;
use common\models\core\UserSession;
use common\models\core\UserSetting;
use Yii;
use common\models\core\User;
use yii\filters\VerbFilter;
use yii\web\Cookie;


class ApiController extends BaseController {

    public function behaviors() {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'settagscan' => ['GET', 'POST', 'PUT', 'PATCH'],
                    'tagidscan' => ['GET', 'POST', 'PUT', 'PATCH'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionSettagscan() {
        if (isset($_POST)) {
            $body = file_get_contents("php://input");
            $result = json_decode($body, true);
            if (isset($result['Properties']['COUNTRY'], $result['Properties']['PNR'])) {
                $user = User::findByCountryPnr($result['Properties']['COUNTRY'], $result['Properties']['PNR'], \Yii::$app->params['default_site_settings']['instance']);
                if (!$user) {
                    $user = new User();
                    $user->country = $result['Properties']['COUNTRY'];
                    $user->pnr = $result['Properties']['PNR'];
                    $user->first_name = ($result['Properties']['FIRST'] ?? "N/A");
                    $user->last_name = ($result['Properties']['LAST'] ?? "N/A");
                    $user->auth_key = \Yii::$app->security->generateRandomString();
                    $user->access_token = \Yii::$app->security->generateRandomString();
                    $user->status = 'verified';
                    $user->cid = md5(($user->pnr . uniqid('', true) ));
                    $user->instance = \Yii::$app->params['default_site_settings']['instance'];
                    $user->save();
                }
                $user = User::findByCountryPnr($result['Properties']['COUNTRY'], $result['Properties']['PNR'], \Yii::$app->params['default_site_settings']['instance']);
                UserSession::deleteAll(['uID' => $user->id]);
                $userSession = new UserSession();
                $userSession->sessionID = $result['SessionId'];
                $userSession->uID = $user->id;
                $userSession->save();
                $userPicture = UserSetting::find()->where(['user_id' => $user->id, 'setting' => 'picture'])->one();
                if ((!isset($userPicture) || $userPicture == '') && isset($result['Attachments'][0]['Url'])) {
                    $imgUrl = substr($result['Attachments'][0]['Url'], 8);
                    $url = "https://".Yii::$app->params['tagID_settings']['neuron']."/QuickLogin/{$result['Key']}/{$imgUrl}";
                    $imgName = date('YmdHis') . "_" . mt_rand(0,1000) . ".jpg";
                    if (!file_exists(__DIR__ . "/../../web/uploads/profilePictures/")) {
                        mkdir(__DIR__ . "/../../web/uploads/profilePictures/", 0777, true);
                    }
                    $img = __DIR__ . "/../../web/uploads/profilePictures/" . $imgName;
                    $options = array(
                        CURLOPT_FILE    => fopen($img, 'w'),
                        CURLOPT_TIMEOUT =>  28800, // set this to 8 hours so we dont timeout on big files
                        CURLOPT_URL     => $url
                    );
                    $ch = curl_init();
                    curl_setopt_array($ch, $options);
                    curl_exec($ch);
                    curl_close($ch);
                    $exif = exif_read_data($img);
                    if (!empty($exif['Orientation'])) {
                        $image = imagecreatefromjpeg($img);
                        switch ($exif['Orientation']) {
                            case 3:
                                $image = imagerotate($image, 180, 0);
                                break;
                            case 6:
                                $image = imagerotate($image, -90, 0);
                                break;
                            case 8:
                                $image = imagerotate($image, 90, 0);
                                break;
                        }
                        imagejpeg($image, $img, 100);
                    }
                    $picture = new Picture();
                    $picture->uri = '/uploads/profilePictures/'.$imgName;
                    //$picture->uploaded_by = $user->id;
                    $picture->save();

                    $userSetting = new UserSetting();
                    $userSetting->user_id = $user->id;
                    $userSetting->setting = 'picture';
                    $userSetting->value = (string)$picture->id;
                    $userSetting->save();

                    $systemLog = new SystemLog();
                    $systemLog->user_id = $user->id;
                    $systemLog->instance = $user->instance;
                    $systemLog->message_short = ($user->first_name ?? '').' '.($user->last_name ?? '').' changed profile picture';
                    $systemLog->message = ($user->first_name ?? '').' '.($user->last_name ?? '').' changed their profile picture by scanning the tagID';
                    $dataFormat = [
                        'event' =>  'profpicChange',
                        'user'  =>  $user->id,
                        'method'    =>  'tagID',
                    ];
                    $systemLog->data_format = json_encode($dataFormat);
                    $systemLog->save();
                }
            } else {
                echo Yii::t('core_system', 'something went wrong');
            }
        }
    }

    public function actionTagidscan() {
        if (isset($_SESSION['tagScanSession'])) {
            $session_id = $_SESSION['tagScanSession'];
            $scanPurpose = ($_SESSION['tagScanPurpose'] ?? 'login');
            $userSession = UserSession::find()->where(['sessionID' => $session_id])->one();
            if ($userSession) {
                if ($scanPurpose === 'login') {
                    $user = User::find()->where(['id' => $userSession->uID])->one();
                    if ($user) {
                        $user_entity = User::findIdentity($user->id);
                        if ($user_entity) {
                            Yii::$app->user->login($user_entity);
                            Yii::$app->session->setFlash('success', Yii::t('core_system', 'You have been logged in successfully!'));
                            $systemLog = new SystemLog();
                            $systemLog->user_id = $user->id;
                            $systemLog->instance = $user->instance;
                            $systemLog->message_short = ($user->first_name ?? '').' '.($user->last_name ?? '').' logged in';
                            $systemLog->message = ($user->first_name ?? '').' '.($user->last_name ?? '').' logged in using tagID from ip: '.Yii::$app->request->getUserIP();
                            $dataFormat = [
                                'event' =>  'login',
                                'user'  =>  $user->id,
                                'method'    =>  'tagID',
                                'ip'    =>  Yii::$app->request->getUserIP(),
                            ];
                            $systemLog->data_format = json_encode($dataFormat);
                            $systemLog->save();
                            $userLogin = new UserLogin();
                            $userLogin->user_id = $user->id;
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
                        }
                    } else {
                        Yii::$app->session->setFlash('danger', Yii::t('core_system', 'We can not log you in right now, try again later!'));
                    }
                    $this->redirect(['site/index']);
                } elseif ($scanPurpose === 'mergeQRAccount') {
                    $model = User::findOne(Yii::$app->user->identity->id);
                    $secondAccount = User::find()->where(['id' => $userSession->uID])->one();
                    $_SESSION['secondMergeAccount'] = $secondAccount->cid;
                    return $this->redirect('/user/mergeaccounts');
                } elseif ($scanPurpose === 'addTagID') {
                    $user = User::findOne(Yii::$app->user->identity->id);
                    $secondAccount = User::findOne(['id' => $userSession->uID]);
                    $user->status = 'verified';
                    $user->save();
                    User::mergeAccounts($user, $secondAccount);
                    return $this->redirect('/site/index');
                }
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('core_system', 'Your session id: {session_id} is invalid. We can not process your request!', ['session_id' => $session_id]));
                $this->redirect(['site/index']);
            }
        }
    }

}
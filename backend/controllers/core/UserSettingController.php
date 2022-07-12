<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\SystemLog;
use Yii;
use common\models\core\UserSetting;
use yii\filters\AccessControl;
use yii\web\Cookie;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

class UserSettingController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['set'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['set'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'set' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    public function actionSet($setting, $value, $user_id = null) {
        if (!Yii::$app->user->isGuest) {
            if ($user_id === null) {
                $user_id = Yii::$app->user->identity->id;
            }
            $model = UserSetting::findOne(['user_id' => $user_id, 'setting' => $setting]);
            if (!isset($model)) {
                $model = new UserSetting();
            }
            $model->user_id = Yii::$app->user->identity->id;
            $model->setting = $setting;
            $model->value = $value;
            $model->save();
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed setting: ' . $model->setting;
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed setting: ' . $model->setting . ' to: ' . ($model->value ?? 'Error');
            $dataFormat = [
                'event' => 'changedSetting',
                'user' => Yii::$app->user->identity->id,
                'setting' => $model->setting,
                'value' => $model->value,
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
        }
        if ($setting === 'language') {
            Yii::$app->language = $value;
            $languageCookie = new Cookie([
                'name' => 'language',
                'value' => $value,
                'expire' => time() + 60 * 60 * 24 * 30
            ]);
            Yii::$app->response->cookies->add($languageCookie);
        }
        return $this->redirect(Yii::$app->request->referrer ?? Yii::$app->homeUrl);
    }

}
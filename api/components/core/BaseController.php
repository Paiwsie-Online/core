<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace api\components\core;

use common\models\core\Language;
use DateTime;
use DateTimeZone;
use Yii;
use yii\rest\ActiveController;

class BaseController extends ActiveController {

    public $systemTime;

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $dt = new DateTime('now', new DateTimeZone(Yii::$app->params['defaults']['systemTimeZone']));
        $this->systemTime = $dt->format('Y-m-d H:i:s');
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
        } else {
            $browserLanguage = "en-GB";
        }
        $checkLanguage = Language::find()->where(['language_id' => $browserLanguage, 'status' => '1'])->one();
        $checkLanguageBeta = Language::find()->where(['language_id' => $browserLanguage, 'status' => '2'])->one();
        $preferredLanguage = ($checkLanguage->language_id ?? ($checkLanguageBeta->language_id ?? 'en-US'));
        Yii::$app->language = $preferredLanguage;
        //\lajax\translatemanager\helpers\Language::registerAssets();
        $preferredTimeZone = (Yii::$app->timeZone ?? 'Europe/Stockholm');
        // TODO: Have to change when identify user ny access token
        /*
        if (!Yii::$app->user->isGuest && isset(Yii::$app->user->identity->settingsList['timezone']) && Yii::$app->user->identity->settingsList['timezone'] !== $preferredTimeZone) {
            $preferredTimeZone = Yii::$app->user->identity->settingsList['timezone'];
        }
        */
        Yii::$app->setTimeZone($preferredTimeZone);
        /*
        // check if new invitations exists
        if (!Yii::$app->user->isGuest && isset($_SESSION['organizationInvites'])) {
            foreach ($_SESSION['organizationInvites'] as $key => $value) {
                $invite = OrganizationUserRelationInvitation::find()->where(['cid' => $key])->one();
                if ($invite) {
                    $relation = OrganizationUserRelation::find()->where(['id' => $invite->our_id])->one();
                    if ($relation) {
                        if (!isset($relation->user_id)) {
                            $secondRelation = OrganizationUserRelation::find()->where(['organization_id' => $relation->organization_id, 'user_id' => Yii::$app->user->identity->id])->one();
                            if ($secondRelation) {
                                $relation->delete();
                                unset($_SESSION['organizationInvites'][$key]);
                            } else {
                                $relation->user_id = Yii::$app->user->identity->id;
                                if ($relation->save()) {
                                    unset($_SESSION['organizationInvites'][$key]);
                                }
                            }
                        }
                    } else {
                        unset($_SESSION['invites'][$key]);
                    }
                }
            }
        }
        */

        return true;
    }

}
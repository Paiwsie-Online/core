<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\components\core;

use common\models\core\OrganizationUserRelation;
use common\models\core\OrganizationUserRelationInvitation;
use common\models\core\Language;
use DateTime;
use DateTimeZone;
use Yii;
use yii\web\Controller;
use yii\web\Cookie;

class BaseController extends Controller {

    public $systemTime;

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $dt = new DateTime('now', new DateTimeZone(Yii::$app->params['defaults']['systemTimeZone']));
        $this->systemTime = $dt->getTimestamp();
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
        } else {
            $browserLanguage = "en-GB";
        }
        $checkLanguage = Language::find()->where(['language_id' => $browserLanguage, 'status' => '1'])->one();
        $checkLanguageBeta = Language::find()->where(['language_id' => $browserLanguage, 'status' => '2'])->one();
        $preferredLanguage = isset(Yii::$app->request->cookies['language']) ? (string)Yii::$app->request->cookies['language'] : ($checkLanguage->language_id ?? ($checkLanguageBeta->language_id ?? 'en-US'));
        if (!Yii::$app->user->isGuest) {
            if (isset(Yii::$app->user->identity->settingsList['language']) && Yii::$app->user->identity->settingsList['language'] !== $preferredLanguage) {
                $preferredLanguage = Yii::$app->user->identity->settingsList['language'];
                $languageCookie = new Cookie([
                    'name' => 'language',
                    'value' => $preferredLanguage,
                    'expire' => time() + 60 * 60 * 24 * 30
                ]);
                Yii::$app->response->cookies->add($languageCookie);
            }
        }
        Yii::$app->language = $preferredLanguage;
        //\lajax\translatemanager\helpers\Language::registerAssets();

        $preferredTimeZone = (Yii::$app->timeZone ?? 'Europe/Stockholm');
        if (!Yii::$app->user->isGuest && isset(Yii::$app->user->identity->settingsList['timezone']) && Yii::$app->user->identity->settingsList['timezone'] !== $preferredTimeZone) {
            $preferredTimeZone = Yii::$app->user->identity->settingsList['timezone'];
        }
        Yii::$app->setTimeZone($preferredTimeZone);

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

        // set session testmode
        if (isset(Yii::$app->user->identity->selectedOrganization->kycdone) && Yii::$app->user->identity->selectedOrganization->kycdone === true) {
            if (isset($_SESSION['userSetTestMode']) && $_SESSION['userSetTestMode'] === true) {
                $_SESSION['testMode'] = true;
            } else {
                $_SESSION['testMode'] = false;
            }
        } else {
            $_SESSION['testMode'] = true;
        }
        return true;
    }

}
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace api\controllers\core;

use api\components\core\BaseController;
use common\models\core\UserSetting;
use yii\filters\auth\HttpBearerAuth;

class UserSettingController extends BaseController {

    public $modelClass = UserSetting::class;

    public function behaviors() {
        $behaviors = parent::behaviors();
        // Set the auth mode to bearer (access token)
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];
        return $behaviors;
    }
}
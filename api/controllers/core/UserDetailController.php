<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace api\controllers\core;

use api\components\core\BaseController;
use common\models\core\UserDetail;
use yii\filters\auth\HttpBearerAuth;

class UserDetailController extends BaseController {

    public $modelClass = UserDetail::class;

    public function behaviors() {
        $behaviors = parent::behaviors();
        // Set the auth mode to bearer (access token)
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];
        return $behaviors;
    }
}
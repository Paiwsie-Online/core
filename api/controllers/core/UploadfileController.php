<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace api\controllers\core;

use api\components\core\BaseController;
use common\models\core\File;
use common\models\core\SystemLog;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\BadRequestHttpException;
use yii\web\NotAcceptableHttpException;
use yii\web\ServerErrorHttpException;

class UploadfileController extends BaseController {

    public $modelClass = File::class;

    public function behaviors() {
        $behaviors = parent::behaviors();
        // Set the auth mode to bearer (access token)
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];
        return $behaviors;
    }

    // UNSET STANDARD ACTIONS TO PERSONALIZE THEM AFTER
    public function actions() {
        $actions = parent::actions();
        // To avoid undesired actions
        unset($actions['create']);
        unset($actions['delete']);
        return $actions;
    }

    // UPLOAD A FILE TO FILE TABLE AND EVEN ON THE DISK
    public function actionCreate() {
        if (!empty($_FILES)) {
            if (in_array(explode('.', $_FILES['file']['name'])[count(explode('.', $_FILES['file']['name'])) - 1], Yii::$app->params['allowedExtensions']['images']) || in_array(explode('.', $_FILES['file']['name'])[count(explode('.', $_FILES['file']['name'])) - 1], Yii::$app->params['allowedExtensions']['text_documents']) || in_array(explode('.', $_FILES['file']['name'])[count(explode('.', $_FILES['file']['name'])) - 1], Yii::$app->params['allowedExtensions']['pdf'])) {
                $path = __DIR__ . '/../../web/uploads/files/';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $date = date('YmdHis');
                foreach ($_FILES as $file) {
                    $fileInfo = pathinfo($file['name']);
                    $fileName = str_replace(' ', '-', $fileInfo['filename']);
                    move_uploaded_file($file['tmp_name'], $path . $date . '_' . $fileName . '.' . $fileInfo['extension']);
                    $model = new File();
                    $model->uri = '/uploads/files/' . $date . '_' . $fileName . '.' . $fileInfo['extension'];
                    if ($model->save()) {
                        $systemLog = new SystemLog();
                        $systemLog->user_id = Yii::$app->user->identity->id;
                        $systemLog->instance = Yii::$app->user->identity->instance;
                        $systemLog->message_short = 'User ' . Yii::$app->user->identity->id . ' uploaded file';
                        $systemLog->message = 'User ' . Yii::$app->user->identity->id . ' uploaded a file from ip: ' . Yii::$app->request->getUserIP();
                        $dataFormat = [
                            'event' => 'uploadFile',
                            'user' => Yii::$app->user->identity->id,
                            'ip' => Yii::$app->request->getUserIP(),
                        ];
                        $systemLog->data_format = json_encode($dataFormat);
                        $systemLog->save();
                    }
                }
            } else {
                throw new NotAcceptableHttpException(Yii::t('core_system', 'This file type is not allowed'));
            }
        }
        $model->uri = Yii::$app->params['default_site_settings']['api_url'] . $model->uri;
        return ($model ?? null);
    }

    // DELETE A FILE FROM FILE TABLE AND EVEN ON THE DISK
    public static function actionDelete($file_id = null) {
        if ($file_id === null) {
            if (isset(Yii::$app->request->queryParams['id'])) {
                $file_id = Yii::$app->request->queryParams['id'];
            } else {
                throw new BadRequestHttpException(Yii::t('core_system', 'Missing parameter: id'));
            }
        }
        $model = File::findOne($file_id);
        if ($model) {
            $uri = __DIR__ . '/../../web' . $model->uri;
            if ($model->delete()) {
                // Delete the image from the server
                unlink($uri);
            } else {
                throw new ServerErrorHttpException(Yii::t('core_system', 'Something went wrong'));
            }
        } else {
            throw new NotAcceptableHttpException(Yii::t('core_system', 'The id is not valid'));
        }
    }

}
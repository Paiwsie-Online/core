<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\SystemLog;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

class SystemAdminController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'flush-cache'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => isset(Yii::$app->user->identity),
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->hasAccess('systemAdmin', 'read');
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['flush-cache'],
                        'allow' => isset(Yii::$app->user->identity),
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->hasAccess('systemAdmin', 'update');
                        },
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                    'flush-cache' => ['GET', 'POST', 'PUT', 'PATCH'],
                ],
            ],
        ];
    }

    // SYSTEM MAINTENANCE PAGE
    public function actionIndex() {
        return $this->render('index');
    }

    // ACTION DELETE FOR FLUSH CACHE
    function deleteAll($dir, $remove = false) {
        $structure = glob(rtrim($dir) . '/*');
        if (is_array($structure)) {
            foreach ($structure as $file) {
                if (is_dir($file)) {
                    $this->deleteAll($file, true);
                } else if (is_file($file) && $file) {
                    unlink($file);
                }
            }
        }
        if ($remove) {
            rmdir($dir);
        }
    }

    // ACTION FLUSH CACHE
    public function actionFlushCache() {
        Yii::$app->cache->flush();
        $this->deleteAll(__DIR__ . '/../../runtime');
        Yii::$app->session->setFlash('success', Yii::t('core_system', 'System cache has successfully been flushed!'));
        $systemLog = new SystemLog();
        $systemLog->user_id = Yii::$app->user->identity->id;
        $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' flushed cache';
        $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' flushed cache';
        $dataFormat = [
            'event' => 'flushedCache',
            'user' => Yii::$app->user->identity->id,
            'action' => 'flush cache',
        ];
        $systemLog->data_format = json_encode($dataFormat);
        $systemLog->save();

        return $this->redirect(['index']);
    }

}
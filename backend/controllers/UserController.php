<?php

namespace backend\controllers;

use common\models\Athlete;
use common\models\core\ObjectParticipant;
use common\models\core\SystemLog;
use common\models\User;
use common\models\core\UserSearch;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UserController extends core\UserController
{
    public function actionAddAthlete() {
        $model = new Athlete();
        if ($model->load(Yii::$app->request->post())) {

     /*       $model->first_name = ucwords($model->first_name);
            $model->last_name = ucwords($model->last_name);*/
            if ($model->save()) {
                $model->setFirst_name(ucwords($_POST['Athlete']['first_name']));
                $model->setLast_name(ucwords($_POST['Athlete']['last_name']));
                $userRelation = new ObjectParticipant();
                $userRelation->model = 'common\models\User';
                $userRelation->model_id = Yii::$app->user->identity->id;
                $userRelation->object = $model->id;
                $userRelation->level = $model->defaultParticipantLevel();
                $userRelation->save();
                $teamRelation = new ObjectParticipant();
                $teamRelation->model = 'common\models\Team';
                $teamRelation->model_id = (int)$_POST['Athlete']['team'];
                $teamRelation->object = $model->id;
                $teamRelation->level = $model->defaultParticipantLevel();
                $teamRelation->save();
               /* $systemLog = new SystemLog();
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
                $systemLog->save();*/
                return $this->redirect(['/user/profile']);
            }
            $message = Yii::t('core_user', 'Athlete could not be added! Please contact <a href="mailto:{email}">{email}</a> and send the error message below.', ['email' => Yii::$app->params['default_site_settings']['support_email']]) . '<br>';
            $message .= Html::errorSummary($model);
            $_SESSION['message'] = $message;

            return $this->redirect(['/site/sysmes']);
        }
        return $this->render('add-athlete', [
            'model' => $model,
        ]);
    }
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist'));
    }
    // CHANGE NAME PAGE
    public function actionNameChange($id = null) {
        $model = $this->findModel(Yii::$app->user->identity->id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->first_name = $_POST['User']['first_name'];
            $model->last_name = $_POST['User']['last_name'];

                $model->first_name = ucfirst($model->first_name);
                $model->last_name = ucfirst($model->last_name);
                if ($model->save()) {

                    $systemLog = new SystemLog();
                    $systemLog->user_id = $model->id;
                    $systemLog->instance = $model->instance;
                    $systemLog->message_short = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' changed name';
                    $systemLog->message = ($model->first_name ?? '') . ' ' . ($model->last_name ?? '') . ' changed name: ' . $model->first_name . $model->last_name . ' from ip: ' . Yii::$app->request->getUserIP();
                    $dataFormat = [
                        'event' => 'changeName',
                        'user' => $model->id,
                        'first_name' => $model->first_name,
                        'last_name' => $model->last_name,
                        'ip' => Yii::$app->request->getUserIP(),
                    ];
                    $systemLog->data_format = json_encode($dataFormat);
                    $systemLog->save();
                    Yii::$app->session->setFlash('success', Yii::t('core_user', 'Name has been changed successfully'));
                    return $this->redirect(['profile']);
                }
            }
        return $this->render('name-change', [
            'model' => $model,
        ]);
    }

}
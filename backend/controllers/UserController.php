<?php

namespace backend\controllers;

use common\models\Athlete;
use common\models\core\ObjectParticipant;
use common\models\core\SystemLog;
use common\models\core\User;
use common\models\core\UserSearch;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
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
}
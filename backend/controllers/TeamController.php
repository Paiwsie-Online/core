<?php

namespace backend\controllers;

use common\models\core\Organization;
use common\models\core\OrganizationUserRelation;
use common\models\core\SystemLog;
use common\models\Team;
use Yii;

class TeamController extends core\OrganizationController
{
    public function actionCreateTeam() {
        $this->layout = "core/system_message";
        $model = new Team();
        $model->created_by = Yii::$app->user->identity->id;
        $model->instance = \Yii::$app->params['default_site_settings']['instance'];
        if ($model->load(Yii::$app->request->post())) {
            $model->legal_name = $model->name;
            $model->model = 'common\models\Team';
/*            echo "<pre>";
            var_dump($_POST['Team']['sport']);
            echo "</pre>";
            exit;*/
            $model->save();
            $model->sport = $_POST['Team']['sport'];
            $organizationUserRelation = new OrganizationUserRelation();
            $organizationUserRelation->organization_id = $model->id;
            $organizationUserRelation->user_id = Yii::$app->user->identity->id;
            $organizationUserRelation->title = 'Superadmin';
            $organizationUserRelation->added_by = Yii::$app->user->identity->id;
            $organizationUserRelation->user_level = 'superadmin';
            $organizationUserRelation->status = 'accepted';
            $organizationUserRelation->status_changed = $this->systemTime;
            $organizationUserRelation->save();
            $systemLog = new SystemLog();
            $systemLog->organization_id = $model->id;
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' created a new organization';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' created new organization ' . ($model->name ?? 'Error');
            $dataFormat = [
                'event' => 'createdNewOrganization',
                'user' => Yii::$app->user->identity->id,
                'createdOrganization' => $model->id,
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
            return $this->redirect(['/site/select-organization']);
        }
        return $this->render('create-team', [
            'model' => $model,
        ]);
    }

    public function actionLoginTeam()
    {
        OrganizationUserRelation::setSelectedOrganization($_POST['teamID']);
        return $this->redirect(['/site/index']);
    }
}
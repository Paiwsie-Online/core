<?php

namespace backend\controllers;

use common\models\Association;
use common\models\core\Organization;
use common\models\core\OrganizationUserRelation;
use common\models\core\SystemLog;
use Yii;

class AssociationController extends core\OrganizationController
{
    public function actionCreateAssociation() {
        $this->layout = "core/system_message";
        $model = new Association();
        $model->created_by = Yii::$app->user->identity->id;
        $model->instance = \Yii::$app->params['default_site_settings']['instance'];
        if ($model->load(Yii::$app->request->post())) {
            $model->legal_name = $model->name;
            $model->model = 'common\models\Association';
            $model->save();
            $address = [
                'street'  => $_POST['street'],
                'zip'  => $_POST['zip'],
                'city'  => $_POST['city'],
            ];
            $model->address = $address;
            $organizationUserRelation = new OrganizationUserRelation();
            $organizationUserRelation->organization_id = $model->id;
            $organizationUserRelation->user_id = Yii::$app->user->identity->id;
            $organizationUserRelation->title = 'Superadmin';
            $organizationUserRelation->added_by = Yii::$app->user->identity->id;
            $organizationUserRelation->user_level = 'superadmin';
            $organizationUserRelation->status = 'accepted';
            $organizationUserRelation->status_changed = $this->systemTime;
            $organizationUserRelation->save();
            //OrganizationUserRelation::setSelectedOrganization($model->id);
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
        return $this->render('create-association', [
            'model' => $model,
        ]);
    }
    public function actionLoginAssociation()
    {
        OrganizationUserRelation::setSelectedOrganization($_POST['assocID']);
        return $this->redirect(['/site/index']);
    }
}
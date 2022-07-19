<?php

namespace backend\controllers;

use common\models\core\Organization;
use common\models\core\OrganizationSetting;
use common\models\core\SystemContent;
use common\models\OrganizationUserRelation;
use common\models\OrganizationUserRelationInvitation;
use common\models\User;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class OrganizationUserRelationController extends core\OrganizationUserRelationController
{
/*
   /* public function actionInvite($id = null) {
        if (!isset($id)) {
            $id = Yii::$app->user->identity->selectedOrganization->id;
        }
        $model = new OrganizationUserRelation();
        $parentModel = new OrganizationUserRelationInvitation();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if (Yii::$app->request->isAjax && $parentModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($parentModel);
        }
        if ($model->load(Yii::$app->request->post()) && $parentModel->load(Yii::$app->request->post())) {
            $email = strtolower($parentModel->sent_to);
            $user = User::find()->where(['email' => $email, 'instance' => Yii::$app->params['default_site_settings']['instance']])->one();
            if ($user) {
                $organizationUserRelation = OrganizationUserRelation::findOne(['user_id' => $user->id, 'organization_id' => $id]);
            }
            if (!isset($organizationUserRelation)) {
                $model->organization_id = $id;
                $model->user_id = null;
                //$model->added_by = Yii::$app->user->identity->id;
                $model->selected_organization = 0;
                if ($model->save()) {
                    echo "<pre>";
                    var_dump($model);
                    echo "</pre>";
                    exit;
                    $parentModel->cid = md5(($email . uniqid('', true)));
                    $parentModel->our_id = $model->id;
                    if ($parentModel->save()) {
                        if ($parentModel->sent_via === 'email') {
                            $this->sendInvitationMail($model, $parentModel);
                        }
                        if ($parentModel->sent_via === 'sms') {
                            $this->sendInvitationSms($model, $parentModel);
                        }
                        Yii::$app->session->setFlash('success', Yii::t('core_system', 'Your invitation has been sent to {receiver}!', ['receiver' => $email]));
                        if (isset($_GET['id'])) {
                            return $this->redirect(['/organization/view', 'id' => $id]);
                        } else {
                            return $this->redirect(['list']);
                        }
                    }
                }
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('core_system', 'Can not invite a user that belongs to same organization'));
            }
        }
        $organizationModel = Organization::findOne($id);
        return $this->render('invite', [
            'model' => $model,
            'parentModel' => $parentModel,
            'organizationModel' => $organizationModel
        ]);
    }*/
/*
    private function sendInvitationSms(OrganizationUserRelation $model, OrganizationUserRelationInvitation $parentModel) {
        $organizationSettings = OrganizationSetting::findOne(['organization_id' => Yii::$app->user->identity->selectedOrganization->id, 'setting' => 'content_email_inviteUser']);
        if (isset($organizationSettings)) {
            $message = Yii::t('core_email', $organizationSettings->value, ['platformName' => Yii::$app->params['default_site_settings']['site_name'], 'inviterName' => ($model->addedBy->first_name ?? '') . ' ' . ($model->addedBy->last_name ?? ''), 'organizationName' => $model->organization->name, 'userLevel' => Yii::t('organization_user_relation', ucfirst($model->user_level))]);
        } else {
            $defaultSignature = SystemContent::findOne(['instance' => 'default', 'content' => 'content_email_signature']);
            $message = Yii::t('system_content', $defaultSignature->value, ['platformName' => Yii::$app->params['default_site_settings']['site_name'], 'inviterName' => ($model->addedBy->first_name ?? '') . ' ' . ($model->addedBy->last_name ?? ''), 'organizationName' => $model->organization->name, 'userLevel' => Yii::t('organization_user_relation', ucfirst($model->user_level))]);
        }
        $message .= Yii::t('core_email', '<br><br><strong><a href="{link}">Link to invitation</a></strong><br><br>', ['link' => Yii::$app->params['default_site_settings']['base_url'] . '/site/get-organization-invite?cid=' . $parentModel->cid]);
        $signature = OrganizationSetting::findOne(['organization_id' => Yii::$app->user->identity->selectedOrganization->id, 'setting' => 'content_email_signature']);
        if (isset($signature)) {
            $message .= $signature->value;
        } else {
            $defaultSignature = SystemContent::findOne(['instance' => 'default', 'content' => 'content_email_signature']);
            $message .= Yii::t('system_content', $defaultSignature->value);
        }
        $subject = Yii::t('core_user', 'Invitation to {platformName}', ['platformName' => Yii::$app->params['default_site_settings']['site_name']]);
        return $this->sendSms($message, $subject, $parentModel->sent_to);
    }

    private function sendSms(string $message, string $subject, ?string $email) {
        Yii::$app->mailer->compose()
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['default_site_settings']['site_name'] . ' - ' . Yii::t('core_user', 'Invitation')])
            ->setReplyTo([Yii::$app->params['senderEmail'] => Yii::$app->params['default_site_settings']['site_name'] . ' - ' . Yii::t('core_user', 'Invitation')])
            ->setTo($email)
            ->setSubject($subject)
            ->setTextBody($message)
            ->setHtmlBody($message)
            ->send();
        return 'OK';
    }*/

}

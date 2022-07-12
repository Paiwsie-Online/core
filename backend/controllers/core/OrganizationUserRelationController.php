<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\Organization;
use common\models\core\OrganizationSetting;
use common\models\core\OrganizationUsergroupUserRelation;
use common\models\core\OrganizationUserRelationInvitation;
use common\models\core\SystemContent;
use common\models\core\SystemLog;
use common\models\core\User;
use Yii;
use common\models\core\OrganizationUserRelation;
use common\models\core\OrganizationUserRelationSearch;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class OrganizationUserRelationController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['list', 'view', 'invite', 'update', 'delete', 'delete-from-organization', 'respond-invitation'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['list', 'view', 'invite', 'update', 'delete', 'delete-from-organization'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->checkUserLevel() === true) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['respond-invitation'],
                        'allow' => isset(Yii::$app->user->identity),
                        'roles' => ['@'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['GET'],
                    'view' => ['GET'],
                    'delete' => ['GET', 'POST', 'DELETE'],
                    'invite' => ['GET', 'POST'],
                    'delete-from-organization' => ['GET', 'POST', 'DELETE'],
                    'update' => ['GET', 'POST', 'PUT', 'PATCH'],
                    'respond-invitation' => ['GET', 'POST']
                ],
            ],
        ];
    }

    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionInvite($id = null) {
        if (!isset($id)) {
            $id = Yii::$app->user->identity->selectedOrganization->id;
        }
        $model = new OrganizationUserRelation();
        $parentModel = new OrganizationUserRelationInvitation();
        if ($model->load(Yii::$app->request->post()) && $parentModel->load(Yii::$app->request->post())) {
            $email = strtolower($parentModel->sent_to);
            $user = User::findOne(['email' => $email, 'instance' => Yii::$app->params['default_site_settings']['instance']]);
            if ($user) {
                $organizationUserRelation = OrganizationUserRelation::findOne(['user_id' => $user->id, 'organization_id' => $id]);
            }
            if (!isset($organizationUserRelation)) {
                $model->organization_id = $id;
                $model->user_id = null;
                $model->added_by = Yii::$app->user->identity->id;
                $model->selected_organization = 0;
                if ($model->save()) {
                    $parentModel->cid = md5(($email . uniqid('', true)));
                    $parentModel->our_id = $model->id;
                    if ($parentModel->save()) {
                        if ($parentModel->sent_via === 'email') {
                            $this->sendInvitationMail($model, $parentModel);
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
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $user = User::getUserName($model->user_id);
            $systemLog = new SystemLog();
            $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization['id'];
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' updated user data';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' updated user data Title: ' . ($model->title ?? 'Error!') . ' and UserLevel: ' . ($model->user_level ?? 'Error!') . ' to ' . ($user ?? 'Error');
            $dataFormat = [
                'event' => 'updateUserData',
                'user' => Yii::$app->user->identity->id,
                'updatedTitle' => $model->title,
                'updatedUserLevel' => $model->user_level,
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }

    protected function findModel($id) {
        if (($model = OrganizationUserRelation::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist'));
    }

    public function actionList() {
        $searchModel = new OrganizationUserRelationSearch();
        $dataProvider = $searchModel->searchList(Yii::$app->request->queryParams);
        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeleteFromOrganization($id) {
        $model = $this->findModel($id);
        $this->findModel($id)->delete();
        $systemLog = new SystemLog();
        $user = User::getUserName($model->user_id);
        $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization['id'];
        $systemLog->user_id = Yii::$app->user->identity->id;
        $systemLog->instance = Yii::$app->user->identity->instance;
        $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' removed a user from organization';
        $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' removed user ' . ($user ?? 'Error') . ' from organization ' . (Yii::$app->user->identity->selectedOrganization['name'] ?? 'Error!');
        $dataFormat = [
            'event' => 'removeUserFromGroup',
            'user' => Yii::$app->user->identity->id,
            'removedUser' => $model->user_id,
            'fromOrganization' => Yii::$app->user->identity->selectedOrganization['id'],
        ];
        $systemLog->data_format = json_encode($dataFormat);
        $systemLog->save();
        return $this->redirect(['/site/index']);
    }

    public function actionRespondInvitation($id, $response) {
        $model = $this->findModel($id);
        $model->status = $response;
        $model->status_changed = $this->systemTime;
        $curInvitation = OrganizationUserRelationInvitation::find()->where(['our_id' => $model->id])->one();
        if ($model->save()) {
            if ($model->status === 'accepted') {
                $inviteParams = json_decode($curInvitation->invite_params, true);
                if (isset($inviteParams['userGroups'])) {
                    foreach ($inviteParams['userGroups'] as $userGroup) {
                        $cUUR = new OrganizationUsergroupUserRelation();
                        $cUUR->ou_relation_id = $model->id;
                        $cUUR->group_id = $userGroup;
                        $cUUR->added_by = $model->added_by;
                        $cUUR->save();
                    }
                }
            }
        }
        $curInvitation->delete();
        return $this->goHome();
    }

    private function sendInvitationMail(OrganizationUserRelation $model, OrganizationUserRelationInvitation $parentModel) {
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
        return $this->sendMail($message, $subject, $parentModel->sent_to);
    }

    private function sendMail(string $message, string $subject, ?string $email) {
        Yii::$app->mailer->compose()
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['default_site_settings']['site_name'] . ' - ' . Yii::t('core_user', 'Invitation')])
            ->setReplyTo([Yii::$app->params['senderEmail'] => Yii::$app->params['default_site_settings']['site_name'] . ' - ' . Yii::t('core_user', 'Invitation')])
            ->setTo($email)
            ->setSubject($subject)
            ->setTextBody($message)
            ->setHtmlBody($message)
            ->send();
        return 'OK';
    }

}
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\OrganizationUsergroup;
use common\models\core\OrganizationUserRelation;
use common\models\core\SystemLog;
use common\models\core\User;
use Yii;
use common\models\core\OrganizationUsergroupUserRelation;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class OrganizationUsergroupUserRelationController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete', 'add-group'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['delete', 'add-group'],
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
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET', 'POST', 'DELETE'],
                    'add-group' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        $this->findModel($id)->delete();
        $user = OrganizationUserRelation::find()->where(['id' => $model->ou_relation_id])->one();
        $removedUser = User::getUserName($user->user_id);
        $group = OrganizationUserGroup::find()->where(['id' => $model->group_id])->one();
        $systemLog = new SystemLog();
        $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization['id'];
        $systemLog->user_id = Yii::$app->user->identity->id;
        $systemLog->instance = Yii::$app->user->identity->instance;
        $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' removed a user from group';
        $systemLog->message = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' removed user ' . ($removedUser ?? 'Error') . ' from group ' . ($group->name ?? 'Error!');
        $dataFormat = [
            'event' =>  'removeUserFromGroup',
            'user'  =>  Yii::$app->user->identity->id,
            'removedUser' => $user->user_id,
            'fromGroup' => $model->group_id,
        ];
        $systemLog->data_format = json_encode($dataFormat);
        $systemLog->save();
        return $this->redirect(Yii::$app->request->referrer ?? Yii::$app->homeUrl);
    }

    protected function findModel($id) {
        if (($model = OrganizationUsergroupUserRelation::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist'));
    }

    public function actionAddGroup($id) {
        $model = new OrganizationUsergroupUserRelation();
        $parentModel = OrganizationUserRelation::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->ou_relation_id = $parentModel->id;
            $model->added_by = Yii::$app->user->identity->id;
            if (!OrganizationUsergroupUserRelation::find()->where(['ou_relation_id' => $model->ou_relation_id, 'group_id' => $model->group_id])->one()) {
                if ($model->save()) {
                    $user = OrganizationUserRelation::find()->where(['id' => $model->ou_relation_id])->one();
                    $addedUser = User::getUserName($user->user_id);
                    $addedGroup = OrganizationUserGroup::find()->where(['id' => $model->group_id])->one();
                    $systemLog = new SystemLog();
                    $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization['id'];
                    $systemLog->user_id = Yii::$app->user->identity->id;
                    $systemLog->instance = Yii::$app->user->identity->instance;
                    $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' added user to user group';
                    $systemLog->message = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' added user ' . ($addedUser ?? 'Error') . ' to group ' . ($addedGroup->name ?? 'Error!');
                    $dataFormat = [
                        'event' =>  'addedUserToGroup',
                        'user'  =>  Yii::$app->user->identity->id,
                        'addedUser'  =>  $user->user_id,
                        'addedGroup' => $model->group_id,
                    ];
                    $systemLog->data_format = json_encode($dataFormat);
                    $systemLog->save();
                    Yii::$app->session->setFlash('success', Yii::t('core_user', 'User successfully added to this group'));
                    return $this->redirect(['/organization-user-relation/view', 'id' => $parentModel->id]);
                }
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('core_user', 'User is already in this group'));
            }
        }
        return $this->render('/organization-user-relation/add-group', [
            'model' => $model,
            'parentModel' => $parentModel,
        ]);
    }

}
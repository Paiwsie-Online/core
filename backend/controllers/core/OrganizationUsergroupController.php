<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\OrganizationUsergroupUserRelation;
use common\models\core\OrganizationUserRelation;
use common\models\core\SystemLog;
use common\models\core\User;
use Yii;
use common\models\core\OrganizationUsergroup;
use common\models\core\OrganizationUsergroupSearch;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class OrganizationUsergroupController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'list', 'update', 'newgroup', 'add-user', 'delete-from-organization'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['view', 'list', 'update', 'newgroup', 'add-user', 'delete-from-organization'],
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
                    'view' => ['GET'],
                    'newgroup' => ['GET', 'POST'],
                    'list' => ['GET'],
                    'update' => ['GET', 'POST', 'PUT', 'PATCH'],
                    'add-user' => ['GET', 'POST'],
                    'delete-from-organization' => ['GET', 'POST', 'DELETE'],
                ],
            ],
        ];
    }

    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $systemLog = new SystemLog();
            $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization['id'];
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed group name';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed group name ' . ($model->name ?? 'Error');
            $dataFormat = [
                'event' => 'changeGroupName',
                'user' => Yii::$app->user->identity->id,
                'changedGroupName' => $model->id,
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function findModel($id) {
        if (($model = OrganizationUsergroup::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist'));
    }

    public function actionList() {
        $searchModel = new OrganizationUsergroupSearch();
        $dataProvider = $searchModel->searchList(Yii::$app->request->queryParams);
        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNewgroup() {
        $model = new OrganizationUsergroup();
        if ($model->load(Yii::$app->request->post())) {
            $model->organization_id = Yii::$app->user->identity->selectedOrganization['id'];
            $model->created_by = Yii::$app->user->identity->id;
            if ($model->save()) {
                $systemLog = new SystemLog();
                $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization['id'];
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' created a new group';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' created new group ' . ($model->name ?? 'Error');
                $dataFormat = [
                    'event' => 'createNewGroup',
                    'user' => Yii::$app->user->identity->id,
                    'createdGroup' => $model->id,
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('newgroup', [
            'model' => $model,
        ]);
    }

    public function actionAddUser($id) {
        $model = new OrganizationUsergroupUserRelation();
        $parentModel = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->group_id = $parentModel->id;
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
                    $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' added user to user group';
                    $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' added user ' . ($addedUser ?? 'Error') . ' to group ' . ($addedGroup->name ?? 'Error!');
                    $dataFormat = [
                        'event' => 'addedUserToGroup',
                        'user' => Yii::$app->user->identity->id,
                        'addedUser' => $user->user_id,
                        'addedGroup' => $model->group_id,
                    ];
                    $systemLog->data_format = json_encode($dataFormat);
                    $systemLog->save();
                    Yii::$app->session->setFlash('success', Yii::t('core_user', 'User successfully added to this group'));
                    return $this->redirect(['view', 'id' => $parentModel->id]);
                }
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('core_user', 'User is already in this group'));
            }
        }
        return $this->render('add-user', [
            'model' => $model,
            'parentModel' => $parentModel,
        ]);
    }

    public function actionDeleteFromOrganization($id) {
        $model = $this->findModel($id);
        $this->findModel($id)->delete();
        $systemLog = new SystemLog();
        $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization['id'];
        $systemLog->user_id = Yii::$app->user->identity->id;
        $systemLog->instance = Yii::$app->user->identity->instance;
        $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' deleted a group';
        $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' deleted a group ' . ($model->name ?? 'Error');
        $dataFormat = [
            'event' => 'deleteGroup',
            'user' => Yii::$app->user->identity->id,
            'deletedGroup' => $model->id,
        ];
        $systemLog->data_format = json_encode($dataFormat);
        $systemLog->save();
        return $this->redirect(['list']);
    }

}
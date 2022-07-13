<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\OrganizationApiKey;
use common\models\core\OrganizationModuleRelation;
use common\models\core\SiteadminApiKey;
use common\models\core\SystemadminApiKey;
use common\models\core\SystemLog;
use Yii;
use common\models\core\ApiKey;
use common\models\core\ApiKeySearch;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ApiKeyController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index-organization', 'create-organization', 'view-organization', 'update-organization', 'delete', 'update-rights', 'index-site-admin', 'create-siteadmin','view-site-admin', 'update-site-admin'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['index-organization', 'create-organization'],
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
                        'actions' => ['view-organization'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->checkUserLevel() === true) {
                                $hasAccess = true;
                            }
                            if (Yii::$app->user->identity->hasAccess('siteAdmin', 'read') === true) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update-organization', 'update-rights'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->checkUserLevel() === true) {
                                $hasAccess = true;
                            }
                            if (Yii::$app->user->identity->hasAccess('siteAdmin', 'update') === true) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->checkUserLevel() === true) {
                                $hasAccess = true;
                            }
                            if (Yii::$app->user->identity->hasAccess('siteAdmin', 'delete') === true) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index-site-admin', 'view-site-admin'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                           return Yii::$app->user->identity->hasAccess('siteAdmin', 'read');
                       },
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create-siteadmin'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->hasAccess('siteAdmin', 'create');
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update-site-admin'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->hasAccess('siteAdmin', 'update');
                        },
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index-organization' => ['GET'],
                    'index-site-admin' => ['GET'],
                    'view-site-admin' => ['GET'],
                    'view-organization' => ['GET'],
                    'create-organization' => ['GET', 'POST'],
                    'create-siteadmin' => ['GET', 'POST'],
                    'update-organization' => ['GET', 'POST', 'PUT', 'PATCH'],
                    'update-site-admin' => ['GET', 'POST', 'PUT', 'PATCH'],
                    'delete' => ['GET', 'POST', 'DELETE'],
                ],
            ],
        ];
    }

    // ACTION DELETE (ORGANIZATION)
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index-organization']);
    }

    // GET APIKEY MODEL
    protected function findModel($id) {
        if (($model = ApiKey::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist'));
    }

    // CREATE SITE ADMIN PAGE
    public function actionCreateSiteadmin() {
        $model = new ApiKey();
        if ($model->load(Yii::$app->request->post())) {
            $model->key_type = 'instance';
            $model->key = \Yii::$app->security->generateRandomString();
            $model->instance = Yii::$app->user->identity->instance;
            //$model->created_by = Yii::$app->user->identity->id;
            if ($model->expiry_date === '') {
                $model->expiry_date = null;
            }
            $model->status = 'active';
            if ($model->save()) {
                foreach (Yii::$app->params['modules']['available'] as $module) {
                    $siteAdminApiKey = new SiteadminApiKey();
                    $siteAdminApiKey->key_id = $model->id;
                    $siteAdminApiKey->module_id = $module;
                    $siteAdminApiKey->right_create = 0;
                    $siteAdminApiKey->right_read = 0;
                    $siteAdminApiKey->right_update = 0;
                    $siteAdminApiKey->right_delete = 0;
                    if ($siteAdminApiKey->module_id === 'siteAdmin') {
                        $siteAdminApiKey->right_create = 1;
                        $siteAdminApiKey->right_read = 1;
                        $siteAdminApiKey->right_update = 1;
                        $siteAdminApiKey->right_delete = 1;
                    }
                    //$siteAdminApiKey->rights_given_by = Yii::$app->user->identity->id;
                    $siteAdminApiKey->save();
                }
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' created api key';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' created api key: ' . $model->id;
                $dataFormat = [
                    'event' =>  'createdApiKey',
                    'user'  =>  Yii::$app->user->identity->id,
                    'apiKey' => $model->id,
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
                return $this->redirect(['view-site-admin', 'id' => $model->id]);
            }
        }
        return $this->render('createsiteadmin', [
            'model' => $model,
        ]);
    }

    // INDEX SITE ADMIN PAGE
    public function actionIndexSiteAdmin() {
        $searchModel = new ApiKeySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('indexsiteadmin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // VIEW SITE ADMIN PAGE
    public function actionViewSiteAdmin($id) {
        return $this->render('viewsiteadmin', [
            'model' => $this->findModel($id),
        ]);
    }

    // UPDATE SITE ADMIN PAGE
    public function actionUpdateSiteAdmin($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->expiry_date === '') {
                $model->expiry_date = null;
            }
            if ($model->key_config === '') {
                $model->key_config = null;
            }
            if ($model->save()) {
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' updated api key';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' updated api key: ' . $model->id;
                $dataFormat = [
                    'event' =>  'updatedApiKey',
                    'user'  =>  Yii::$app->user->identity->id,
                    'apiKey' => $model->id,
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
                return $this->redirect(['view-site-admin', 'id' => $model->id]);
            }
        }
        return $this->render('updatesiteadmin', [
            'model' => $model,
        ]);
    }

    // ACTION UPDATE RIGHTS
    public function actionUpdateRights($id, $module_id, $right, int $value, $site) {
        if ($site === 'systemAdmin') {
            $module = SystemadminApiKey::findOne(['key_id' => $id, 'module_id' => $module_id]);
        } else {
            if ($site === 'siteAdmin') {
                $module = SiteadminApiKey::findOne(['key_id' => $id, 'module_id' => $module_id]);
            } else {
                if ($site === 'organization') {
                    $module = OrganizationApiKey::findOne(['key_id' => $id, 'cmr_id' => $module_id]);
                }
            }
        }
        if ($right === 'read') {
            if ($value === 0) {
                $module->right_create = 0;
                $module->right_read = 0;
                $module->right_update = 0;
                $module->right_delete = 0;
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' denied all modules rights for a user';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' denied all rights in module: ' . $module_id . ' for user: ' . Yii::$app->user->identity->id;
                $dataFormat = [
                    'event' => 'denyAllModulesRightsUser',
                    'user' => Yii::$app->user->identity->id,
                    'module' => $module_id,
                    'userChanged' => Yii::$app->user->identity->id,
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();

            }
            if ($value === 1) {
                $module->right_create = ($module->right_create === 1 ? 1 : 0);
                $module->right_read = 1;
                $module->right_update = ($module->right_update === 1 ? 1 : 0);
                $module->right_delete = ($module->right_delete === 1 ? 1 : 0);
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed module right for a user';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed right: read to 1 in module: ' . $module_id . ' for user: ' . Yii::$app->user->identity->id;
                $dataFormat = [
                    'event' => 'changeModuleRightUser',
                    'user' => Yii::$app->user->identity->id,
                    'right' => 'read',
                    'value' => '1',
                    'module' => $module_id,
                    'userChanged' => Yii::$app->user->identity->id,
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();

            }
        } else {
            if ($value === 1) {
                $module->right_read = 1;
                if ($right === 'create') {
                    $module->right_create = $module->right_create = 1;
                }
                if ($right === 'update') {
                    $module->right_update = $module->right_update = 1;
                }
                if ($right === 'delete') {
                    $module->right_delete = $module->right_delete = 1;
                }
            } else {
                if ($right === 'create') {
                    $module->right_create = $module->right_create = 0;
                }
                if ($right === 'update') {
                    $module->right_update = $module->right_update = 0;
                }
                if ($right === 'delete') {
                    $module->right_delete = $module->right_delete = 0;
                }
            }
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed module right for a user';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed right: ' . $right . ' to ' . $value . ' in module: ' . $module_id . ' for user: ' . Yii::$app->user->identity->id;
            $dataFormat = [
                'event' => 'changeModuleRightUser',
                'user' => Yii::$app->user->identity->id,
                'right' =>  $right,
                'value' =>  $value,
                'module' => $module_id,
                'userChanged' => Yii::$app->user->identity->id,
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();

        }
        $module->rights_given = $this->systemTime;
        $module->rights_given_by = Yii::$app->user->identity->id;
        
        if (!$module->save()) {
            Yii::$app->session->setFlash('danger', Yii::t('core_system', 'Something went wrong, please try again!'));
        }
        return $this->redirect(Yii::$app->request->referrer ?? Yii::$app->homeUrl);
    }

    // CREATE ORGANIZATION PAGE
    public function actionCreateOrganization() {
        $model = new ApiKey();
        if ($model->load(Yii::$app->request->post())) {
            $model->key_type = 'organization';
            $model->key = \Yii::$app->security->generateRandomString();
            $model->instance = Yii::$app->user->identity->instance;
            $model->organization_id = Yii::$app->user->identity->selectedOrganization->id;
            //$model->created_by = Yii::$app->user->identity->id;
            if ($model->expiry_date === '') {
                $model->expiry_date = null;
            }
            $model->status = 'active';
            if ($model->save()) {
                $organizationModuleRelation = OrganizationModuleRelation::find()->where(['organization_id' => Yii::$app->user->identity->selectedOrganization->id])->all();
                foreach ($organizationModuleRelation as $module) {
                    $organizationApiKey = new OrganizationApiKey();
                    $organizationApiKey->key_id = $model->id;
                    $organizationApiKey->cmr_id = $module->id;
                    $organizationApiKey->right_create = 0;
                    $organizationApiKey->right_read = 0;
                    $organizationApiKey->right_update = 0;
                    $organizationApiKey->right_delete = 0;
                    //$organizationApiKey->rights_given_by = Yii::$app->user->identity->id;
                    $organizationApiKey->save();
                }
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' created api key';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' created api key: ' . $model->id . ' for Organization: ' . Yii::$app->user->identity->selectedOrganization->id;
                $dataFormat = [
                    'event' =>  'createdApiKey',
                    'user'  =>  Yii::$app->user->identity->id,
                    'apiKey' => $model->id,
                    'organization' => Yii::$app->user->identity->selectedOrganization->id,
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
                return $this->redirect(['view-organization', 'id' => $model->id]);
            }
        }
        return $this->render('createorganization', [
            'model' => $model,
        ]);
    }

    // INDEX ORGANIZATION PAGE
    public function actionIndexOrganization() {
        $searchModel = new ApiKeySearch();
        $dataProvider = $searchModel->searchOrganization(Yii::$app->request->queryParams);
        return $this->render('indexorganization', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // VIEW ORGANIZATION PAGE
    public function actionViewOrganization($id) {
        return $this->render('vieworganization', [
            'model' => $this->findModel($id),
        ]);
    }

    // UPDATE ORGANIZATION PAGE
    public function actionUpdateOrganization($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->expiry_date === '') {
                $model->expiry_date = null;
            }
            if ($model->key_config === '') {
                $model->key_config = null;
            }
            if ($model->save()) {
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' updated api key';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' updated api key: ' . $model->id . ' for Organization: ' . Yii::$app->user->identity->selectedOrganization->id;
                $dataFormat = [
                    'event' =>  'updatedApiKey',
                    'user'  =>  Yii::$app->user->identity->id,
                    'apiKey' => $model->id,
                    'organization' => Yii::$app->user->identity->selectedOrganization->id,
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
                return $this->redirect(['view-organization', 'id' => $model->id]);
            }
        }
        return $this->render('updateorganization', [
            'model' => $model,
        ]);
    }

}

<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\OrganizationModuleRelation;
use common\models\core\OrganizationSetting;
use common\models\core\OrganizationUserRelation;
use common\models\core\SystemLog;
use Yii;
use common\models\core\Organization;
use common\models\core\OrganizationSearch;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class OrganizationController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'register-organization', 'modules', 'add-organization-modules', 'delete-organization-modules', 'add-affiliate', 'delete-affiliated'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->hasAccess('siteAdmin', 'read') || Yii::$app->user->identity->hasAccess('systemAdmin', 'read')) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['register-organization'],
                        'allow' => isset(Yii::$app->user->identity),
                        'matchCallback' => function ($rule, $action) {
                            return isset(Yii::$app->user->identity);
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['modules'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->checkUserLevel() === true) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['add-organization-modules'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->checkUserLevel() === true) {
                                $hasAccess = true;
                            }
                            if (Yii::$app->user->identity->hasAccess('siteAdmin', 'update') || Yii::$app->user->identity->hasAccess('systemAdmin', 'update')) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['delete-organization-modules'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->checkUserLevel() === true) {
                                $hasAccess = true;
                            }
                            if (Yii::$app->user->identity->hasAccess('siteAdmin', 'delete') || Yii::$app->user->identity->hasAccess('systemAdmin', 'delete')) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['add-affiliate'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->hasAccess('systemAdmin', 'update')) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['delete-affiliated'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->hasAccess('systemAdmin', 'delete')) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                    'modules' => ['GET'],
                    'register-organization' => ['GET', 'POST'],
                    'add-organization-modules' => ['GET', 'POST'],
                    'delete-organization-modules' => ['GET', 'POST'],
                    'add-affiliate' => ['GET', 'POST'],
                    'delete-affiliated' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    // INDEX PAGE
    public function actionIndex() {
        $searchModel = new OrganizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // VIEW PAGE
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    // CREATE ORGANIZATION PAGE
    public function actionRegisterOrganization() {
        $model = new Organization();
        //$model->created_by = Yii::$app->user->identity->id;
        $model->instance = \Yii::$app->params['default_site_settings']['instance'];
        if ($model->load(Yii::$app->request->post())) {
            $model->legal_name = $model->name;
            $model->save();
            $organizationUserRelation = new OrganizationUserRelation();
            $organizationUserRelation->organization_id = $model->id;
            $organizationUserRelation->user_id = Yii::$app->user->identity->id;
            $organizationUserRelation->title = 'Owner';
            //$organizationUserRelation->added_by = Yii::$app->user->identity->id;
            $organizationUserRelation->user_level = 'owner';
            $organizationUserRelation->status = 'accepted';
            $organizationUserRelation->status_changed = $this->systemTime;
            $organizationUserRelation->save();
            OrganizationUserRelation::setSelectedOrganization($model->id);
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
            return $this->redirect(['/site/index']);
        }
        return $this->render('registerorganization', [
            'model' => $model,
        ]);
    }

    // FIND MODEL
    protected function findModel($id) {
        if (($model = Organization::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist'));
    }

    // ACTION CHANGE TO SELECTED ORGANIZATION
    public function actionChangeActive() {
        OrganizationUserRelation::setSelectedOrganization($_POST['id']);
        $this->redirect(['site/index']);
    }

    // ACTION ADD MODULE
    public function actionAddOrganizationModules(int $organization_id, $module_id) {
        $organizationModuleRelation = new OrganizationModuleRelation();
        $organizationModuleRelation->organization_id = $organization_id;
        $organizationModuleRelation->module_id = $module_id;
        if ($organizationModuleRelation->save()) {
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->organization_id = $organization_id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' added organization module';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' added organization module: ' . $module_id . ' for organization:  ' . $organization_id . ' from ip: ' . Yii::$app->request->getUserIP();
            $dataFormat = [
                'event' => 'addOrganizationModule',
                'user' => Yii::$app->user->identity->id,
                'module' => $module_id,
                'organization' => $organization_id,
                'ip' => Yii::$app->request->getUserIP(),
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
            return $this->redirect(Yii::$app->request->referrer ?? Yii::$app->homeUrl);
        }
    }

    // ACTION DELETE MODULE
    public function actionDeleteOrganizationModules(int $organization_id, $module_id) {
        $organizationModuleRelation = OrganizationModuleRelation::findOne(['organization_id' => $organization_id, 'module_id' => $module_id]);
        if ($organizationModuleRelation->delete()) {
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->organization_id = $organization_id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' deleted organization module';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' deleted organization module: ' . $module_id . ' for organization:  ' . $organization_id . ' from ip: ' . Yii::$app->request->getUserIP();
            $dataFormat = [
                'event' => 'deleteOrganizationModule',
                'user' => Yii::$app->user->identity->id,
                'module' => $module_id,
                'organization' => $organization_id,
                'ip' => Yii::$app->request->getUserIP(),
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
            return $this->redirect(Yii::$app->request->referrer ?? Yii::$app->homeUrl);
        }
    }

    // MODULES PAGE
    public function actionModules() {
        return $this->render('modules', [
            'model' => $this->findModel(Yii::$app->user->identity->selectedOrganization->id),
        ]);
    }

    // ADD AFFILIATE
    public function actionAddAffiliate() {
        if (isset($_POST['affiliate'])) {
            $organizationSettings = new OrganizationSetting();
            $organizationSettings->organization_id = (int)$_POST['organizationID'];
            $organizationSettings->setting = 'affiliated';
            $organizationSettings->value = $_POST['affiliate'];
            $organizationSettings->save();
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->organization_id = (int)$_POST['organizationID'];
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' affiliated organization';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' affiliated organization: ' . (int)$_POST['organizationID'] . ' to organization: ' . (int)$_POST['affiliate'];
            $dataFormat = [
                'event' => 'affiliatedOrganization',
                'user' => Yii::$app->user->identity->id,
                'affiliatedOrganization' => (int)$_POST['organizationID'],
                'organization' => (int)$_POST['affiliate'],
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
            Yii::$app->session->setFlash('success', Yii::t('core_system','Affiliate completed successfully'));
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    // DELETE AFFILIATE
    public function actionDeleteAffiliated($organizationID, $affiliatedOrganization = null) {
        if (isset($affiliatedOrganization)) {
            $organizationSettings = OrganizationSetting::findOne(['organization_id' => $affiliatedOrganization, 'setting' => 'affiliated', 'value' => $organizationID]);
        } else {
            $organizationSettings = OrganizationSetting::findOne(['organization_id' => $organizationID, 'setting' => 'affiliated']);
        }
        if (isset($organizationSettings)) {
            $organizationSettings->delete();
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->organization_id = $organizationID;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' deleted affiliate from organization';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' deleted affiliate from organization: ' . $organizationID;
            $dataFormat = [
                'event' => 'deletedAffiliateFromOrganization',
                'user' => Yii::$app->user->identity->id,
                'organization' => $organizationID,
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
            Yii::$app->session->setFlash('success', Yii::t('core_system','Affiliate successfully canceled'));
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

}
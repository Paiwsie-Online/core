<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\OrganizationModuleRelation;
use common\models\core\OrganizationUserRelation;
use common\models\core\SystemLog;
use Yii;
use common\models\core\OrganizationUserModuleRight;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

class OrganizationUserModuleRightController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update-rights', 'remove-individual-rights'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['update-rights', 'remove-individual-rights'],
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
                    'update-rights' => ['GET', 'POST', 'PUT', 'PATCH'],
                    'remove-individual-rights' => ['GET', 'POST', 'DELETE'],
                ],
            ],
        ];
    }

    public function actionUpdateRights($ou_relation_id, $module_id, $right, int $value) {
        $accessRight = 'right_' . $right;
        $organizationUserRelation = OrganizationUserRelation::findOne($ou_relation_id);
        $organizationModuleRelation = OrganizationModuleRelation::findOne(['organization_id' => $organizationUserRelation->organization_id, 'module_id' => $module_id]);
        $moduleRights = OrganizationUserModuleRight::find()->where(['ou_relation_id' => $ou_relation_id, 'cmr_id' => $organizationModuleRelation->id])->one();
        if (!$moduleRights) {
            $moduleRights = new OrganizationUserModuleRight();
            $moduleRights->ou_relation_id = $ou_relation_id;
            $moduleRights->cmr_id = $organizationModuleRelation->id;
        }
        $moduleRights->{$accessRight} = $value;
        if ($right === 'read') {
            if ($value === 0) {
                $moduleRights->right_create = 0;
                $moduleRights->right_update = 0;
                $moduleRights->right_delete = 0;
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' denied all modules rights for a user';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' denied all rights in module: ' . $organizationModuleRelation->id . ' for user: ' . $organizationUserRelation->user_id;
                $dataFormat = [
                    'event' => 'denyAllModulesRightsUser',
                    'user' => Yii::$app->user->identity->id,
                    'module' => $organizationModuleRelation->id,
                    'userChanged' => $organizationUserRelation->user_id,
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
            }
            if ($value === 1) {
                $moduleRights->right_create = ($moduleRights->right_create === 1 ? 1 : 0);
                $moduleRights->right_update = ($moduleRights->right_update === 1 ? 1 : 0);
                $moduleRights->right_delete = ($moduleRights->right_delete === 1 ? 1 : 0);
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed module right for a user';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed right: read to 1 in module: ' . $organizationModuleRelation->id . ' for user: ' . $organizationUserRelation->user_id;
                $dataFormat = [
                    'event' => 'changeModuleRightUser',
                    'user' => Yii::$app->user->identity->id,
                    'right' => 'read',
                    'value' => '1',
                    'module' => $organizationModuleRelation->id,
                    'userChanged' => $organizationUserRelation->user_id,
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
            }
        } elseif ($right !== 'read') {
            if ($value === 1) {
                $moduleRights->right_read = 1;
                if ($right !== 'create') {
                    $moduleRights->right_create = ($moduleRights->cuRelation->user->hasAccess($module_id, 'create', false) ? 1 : 0);
                }
                if ($right !== 'update') {
                    $moduleRights->right_update = ($moduleRights->cuRelation->user->hasAccess($module_id, 'update', false) ? 1 : 0);
                }
                if ($right !== 'delete') {
                    $moduleRights->right_delete = ($moduleRights->cuRelation->user->hasAccess($module_id, 'delete', false) ? 1 : 0);
                }
            }
            if ($value === 0) {
                if ($right !== 'create') {
                    $moduleRights->right_create = ($moduleRights->cuRelation->user->hasAccess($module_id, 'create', false) ? 1 : 0);
                }
                if ($right !== 'update') {
                    $moduleRights->right_update = ($moduleRights->cuRelation->user->hasAccess($module_id, 'update', false) ? 1 : 0);
                }
                if ($right !== 'delete') {
                    $moduleRights->right_delete = ($moduleRights->cuRelation->user->hasAccess($module_id, 'delete', false) ? 1 : 0);
                }
            }
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed module right for a user';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed right: ' . $right . ' to ' . $value . ' in module: ' . $organizationModuleRelation->id . ' for user: ' . $organizationUserRelation->user_id;
            $dataFormat = [
                'event' => 'changeModuleRightUser',
                'user' => Yii::$app->user->identity->id,
                'right' => $right,
                'value' => $value,
                'module' => $organizationModuleRelation->id,
                'userChanged' => $organizationUserRelation->user_id,
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
        }
        //$moduleRights->rights_given = $this->systemTime;
        //$moduleRights->rights_given_by = Yii::$app->user->identity->id;
        if (!$moduleRights->save()) {
            Yii::$app->session->setFlash('danger', Yii::t('core_system', 'Something went wrong, please try again!'));
        }
        return $this->redirect(Yii::$app->request->referrer ?? Yii::$app->homeUrl);
    }

    public function actionRemoveIndividualRights($ou_relation_id, $cmr_id) {
        $moduleRights = OrganizationUserModuleRight::find()->where(['ou_relation_id' => $ou_relation_id, 'cmr_id' => $cmr_id])->one();
        $organizationModuleRelation = OrganizationModuleRelation::findOne(['id' => $cmr_id]);
        $organizationUserRelation = OrganizationUserRelation::findOne(['id' => $ou_relation_id]);
        if (!$moduleRights) {
            $moduleRights = new OrganizationUserModuleRight();
            $moduleRights->ou_relation_id = $ou_relation_id;
            $moduleRights->cmr_id = $cmr_id;
        }
        $moduleRights->right_create = 2;
        $moduleRights->right_read = 2;
        $moduleRights->right_update = 2;
        $moduleRights->right_delete = 2;
        //$moduleRights->rights_given = $this->systemTime;
        //$moduleRights->rights_given_by = Yii::$app->user->identity->id;
        $systemLog = new SystemLog();
        $systemLog->user_id = Yii::$app->user->identity->id;
        $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
        $systemLog->instance = Yii::$app->user->identity->instance;
        $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' matched module rights with group for a user';
        $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' matched module: ' . $organizationModuleRelation->id . ' rights with group for user: ' . $organizationUserRelation->user_id;
        $dataFormat = [
            'event' => 'changeModuleRightUser',
            'user' => Yii::$app->user->identity->id,
            'module' => $organizationModuleRelation->id,
            'userChanged' => $organizationUserRelation->user_id,
        ];
        $systemLog->data_format = json_encode($dataFormat);
        $systemLog->save();
        if (!$moduleRights->save()) {
            Yii::$app->session->setFlash('danger', Yii::t('core_system', 'Something went wrong, please try again!'));
        }
        return $this->redirect(Yii::$app->request->referrer ?? Yii::$app->homeUrl);
    }

}
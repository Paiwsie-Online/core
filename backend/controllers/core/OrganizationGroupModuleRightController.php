<?php /** @noinspection DuplicatedCode */
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\OrganizationModuleRelation;
use common\models\core\OrganizationUsergroup;
use common\models\core\SystemLog;
use Yii;
use common\models\core\OrganizationGroupModuleRight;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

class OrganizationGroupModuleRightController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update-rights'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['update-rights'],
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
                ],
            ],
        ];
    }

    public function actionUpdateRights($group_id, $module_id, $right, int $value) {
        $accessRight = 'right_'.$right;
        $group = OrganizationUsergroup::findOne($group_id);
        $organizationModuleRelation = OrganizationModuleRelation::findOne(['organization_id' => $group->organization_id, 'module_id' => $module_id]);
        $moduleRights = OrganizationGroupModuleRight::find()->where(['group_id' => $group_id, 'cmr_id' => $organizationModuleRelation->id])->one();
        if(!$moduleRights) {
            $moduleRights = new OrganizationGroupModuleRight();
            $moduleRights->group_id = $group_id;
            $moduleRights->cmr_id = $organizationModuleRelation->id;
        }
        $moduleRights->{$accessRight} = $value;
        $moduleRights->rights_given = $this->systemTime;
        $moduleRights->rights_given_by = Yii::$app->user->identity->id;
        if ($right === 'read') {
            if ($value === 1) {
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' changed module right for a group';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' changed right: read to ' . $value . ' in module: ' . $organizationModuleRelation->id .' for group: ' . $group_id;
                $dataFormat = [
                    'event' =>  'changeModuleRightGroup',
                    'user'  =>  Yii::$app->user->identity->id,
                    'right' =>  'read',
                    'value' =>  $value,
                    'module' => $organizationModuleRelation->id,
                    'group' => $group_id,
                ];
            } else {
                $moduleRights->right_create = 0;
                $moduleRights->right_update = 0;
                $moduleRights->right_delete = 0;
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' denied all modules rights for a group';
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' denied all rights in module: ' . $organizationModuleRelation->id . ' for group: ' . $group_id;
                $dataFormat = [
                    'event' => 'denyAllModulesRightsGroup',
                    'user' => Yii::$app->user->identity->id,
                    'module' => $organizationModuleRelation->id,
                    'group' => $group_id,
                ];
            }
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
        } elseif ($right !== 'read') {
            if ($value === 1) {
                $moduleRights->right_read = 1;
            }
            if ($value === 0 && $moduleRights->right_read === 1) {
                $moduleRights->right_read = 1;
            }
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->organization_id = Yii::$app->user->identity->selectedOrganization->id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' changed module right for a group';
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' changed right: ' . $right . ' to ' . $value . ' in module: ' . $organizationModuleRelation->id .' for group: ' . $group_id;
            $dataFormat = [
                'event' =>  'changeModuleRightGroup',
                'user'  =>  Yii::$app->user->identity->id,
                'right' =>  $right,
                'value' =>  $value,
                'module' => $organizationModuleRelation->id,
                'group' => $group_id,
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
        }
        if (!$moduleRights->save()) {
            Yii::$app->session->setFlash('danger', Yii::t('core_system', 'Something went wrong, please try again!'));
        }
        return $this->redirect(Yii::$app->request->referrer ?? Yii::$app->homeUrl);
    }

}
<?php

namespace common\models;

use common\models\core\Module;
use common\models\core\Organization;
use common\models\core\OrganizationGroupModuleRight;
use common\models\core\OrganizationModuleRelation;
use common\models\core\OrganizationUsergroupUserRelation;
use common\models\core\OrganizationUserModuleRight;
use common\models\core\OrganizationUserRelation;
use Yii;
use yii\helpers\ArrayHelper;
/**
* @property array $teamList
* @property array $assocList
 */
class User extends core\User
{
    public function hasAccess($moduleID, $right, $returnIcon = false, $organization_id = null) {
        $accessRight = 'right_'.$right;
        $module = Module::find()->where(['id' => $moduleID])->one();
        if ($module) {
            $selectedOrganization = Yii::$app->user->identity->selectedOrganization;
            if ($selectedOrganization) {
                if ($organization_id === null) {
                    $organization_id = $selectedOrganization['id'];
                }
            }
            if (!$organization_id) {
                return false;
            }
            $organizationUserRelation = OrganizationUserRelation::find()->where(['organization_id' => $organization_id, 'user_id' => $this->id, 'status' => 'accepted'])->one();
            if ($organizationUserRelation) {
                if ($moduleID !== 'siteAdmin' && $moduleID !== 'systemAdmin') {
                    // CHECK IF HAS SITE ADMIN
                    $organizationModuleRelation = OrganizationModuleRelation::findOne(['organization_id' => $organization_id, 'module_id' => 'siteAdmin']);
                    if ($organizationModuleRelation) {
                        if ($this->getOrganizationUserLevel($organization_id) === 'superadmin' || $this->getOrganizationUserLevel($organization_id) === 'cashier') {
                            return ($returnIcon ? '<i class="fas fa-check-square fa-2x text-secondary"></i>' : true);
                        }
                        $organizationUserModuleRights = OrganizationUserModuleRight::find()->where(['ou_relation_id' => $organizationUserRelation->id, 'cmr_id' => $organizationModuleRelation->id])->one();
                        if ($organizationUserModuleRights) {
                            if ($organizationUserModuleRights->{$accessRight} === 1) {
                                return ($returnIcon ? '<i class="far fa-check-square fa-2x"></i>' : true);
                            }
                        }
                        $organizationUsergroupUserRelation = OrganizationUsergroupUserRelation::find()->where(['ou_relation_id' => $organizationUserRelation->id])->all();
                        if ($organizationUsergroupUserRelation) {
                            foreach ($organizationUsergroupUserRelation as $cuur) {
                                $organizationGroupModuleRights = OrganizationGroupModuleRight::find()->where(['group_id' => $cuur->group_id, 'cmr_id' => $organizationModuleRelation->id])->one();
                                if (isset($organizationGroupModuleRights) && $organizationGroupModuleRights->{$accessRight} === 1) {
                                    return ($returnIcon ? '<i class="fas fa-check-square fa-2x"></i>' : true);
                                }
                            }
                        }
                    }
                    // CHECK IF HAS SYSTEM ADMIN
                    $organizationModuleRelation = OrganizationModuleRelation::findOne(['organization_id' => $organization_id, 'module_id' => 'systemAdmin']);
                    if ($organizationModuleRelation) {
                        if ($this->getOrganizationUserLevel($organization_id) === 'superadmin' || $this->getOrganizationUserLevel($organization_id) === 'cashier') {
                            return ($returnIcon ? '<i class="fas fa-check-square fa-2x text-secondary"></i>' : true);
                        }
                        $organizationUserModuleRights = OrganizationUserModuleRight::find()->where(['ou_relation_id' => $organizationUserRelation->id, 'cmr_id' => $organizationModuleRelation->id])->one();
                        if ($organizationUserModuleRights) {
                            if ($organizationUserModuleRights->{$accessRight} === 1) {
                                return ($returnIcon ? '<i class="far fa-check-square fa-2x"></i>' : true);
                            }
                        }
                        $organizationUsergroupUserRelation = OrganizationUsergroupUserRelation::find()->where(['ou_relation_id' => $organizationUserRelation->id])->all();
                        if ($organizationUsergroupUserRelation) {
                            foreach ($organizationUsergroupUserRelation as $cuur) {
                                $organizationGroupModuleRights = OrganizationGroupModuleRight::find()->where(['group_id' => $cuur->group_id, 'cmr_id' => $organizationModuleRelation->id])->one();
                                if (isset($organizationGroupModuleRights) && $organizationGroupModuleRights->{$accessRight} === 1) {
                                    return ($returnIcon ? '<i class="fas fa-check-square fa-2x"></i>' : true);
                                }
                            }
                        }
                    }
                }
                $organizationModuleRelation = OrganizationModuleRelation::find()->where(['organization_id' =>  $organization_id, 'module_id' => $module->id])->one();
                if ($organizationModuleRelation) {
                    if ($this->getOrganizationUserLevel($organization_id) === 'superadmin' || $this->getOrganizationUserLevel($organization_id) === 'cashier') {
                        return ($returnIcon ? '<i class="fas fa-check-square fa-2x text-secondary"></i>' : true);
                    }
                    $organizationUserModuleRights = OrganizationUserModuleRight::find()->where(['ou_relation_id' => $organizationUserRelation->id, 'cmr_id' => $organizationModuleRelation->id])->one();
                    if ($organizationUserModuleRights) {
                        if ($organizationUserModuleRights->{$accessRight} === 1) {
                            return ($returnIcon ? '<i class="far fa-check-square fa-2x"></i>' : true);
                        }
                        if ($organizationUserModuleRights->{$accessRight} === 0) {
                            return ($returnIcon ? '<i class="far fa-times-square fa-2x"></i>' : false);
                        }
                    }
                    $organizationUsergroupUserRelation = OrganizationUsergroupUserRelation::find()->where(['ou_relation_id' => $organizationUserRelation->id])->all();
                    if ($organizationUsergroupUserRelation) {
                        foreach ($organizationUsergroupUserRelation as $cuur) {
                            $organizationGroupModuleRights = OrganizationGroupModuleRight::find()->where(['group_id' => $cuur->group_id, 'cmr_id' => $organizationModuleRelation->id])->one();
                            if (isset($organizationGroupModuleRights) && $organizationGroupModuleRights->{$accessRight} === 1) {
                                return ($returnIcon ? '<i class="fas fa-check-square fa-2x"></i>' : true);
                            }
                        }
                    }
                }
            }
        }
        return ($returnIcon ? '<i class="fas fa-times-square fa-2x"></i>' : false);
    }

    // RETURN ARRAY TEAM LIST BY USER
    public function getTeamList() {
        $temp_list = $this->hasMany(Organization::className(), ['id' => 'organization_id'])->andWhere(['model' => 'common\models\Team'])->viaTable('organization_user_relation', ['user_id' => 'id'], function($query){
            $query->andWhere(['status' => 'accepted']);
        })->asArray()->all();
        return ArrayHelper::map($temp_list, 'id', 'name');
        //return $temp_list;
    }
    public function getAssocList() {
        $temp_list = $this->hasMany(Organization::className(), ['id' => 'organization_id'])->andWhere(['model' => 'common\models\Association'])->viaTable('organization_user_relation', ['user_id' => 'id'], function($query){
            $query->andWhere(['status' => 'accepted']);
        })->asArray()->all();
        return ArrayHelper::map($temp_list, 'id', 'name');
        //return $temp_list;
    }
}
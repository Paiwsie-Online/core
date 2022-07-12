<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**

 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string|null $additional_data

 * @property OrganizationModuleRelation[] $organizationModuleRelations
 * @property Organization[] $organizations
 */

class Module extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'module';
    }

    public function rules() {
        return [
            [['id', 'name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['id'], 'unique', 'message' => 'identifier must be unique.'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID') . '*',
            'name' => Yii::t('core_model', 'Name') . '*',
            'description' => Yii::t('core_model', 'Description'),
            'additional_data'   =>  Yii::t('core_model', 'Additional data'),
        ];
    }

    public function getOrganizationModuleRelations() {
        return $this->hasMany(OrganizationModuleRelation::className(), ['module_id' => 'id']);
    }

    public function getOrganizations() {
        return $this->hasMany(Organization::className(), ['id' => 'organization_id'])->viaTable('organization_module_relation', ['module_id' => 'id']);
    }

    public function dependencies() {
        $dependencies = [];
        $organization = Organization::findOne(Yii::$app->user->identity->selectedOrganization->id);
        if ($organization) {
            if ($this->additional_data !== null) {
                $additional_data = json_decode($this->additional_data);
                if (isset($additional_data->dependencies)) {
                    foreach ($additional_data->dependencies as $dependency) {
                        $moduleInstalled = OrganizationModuleRelation::find()->where(['organization_id' => $organization->id, 'module_id' => $dependency])->one();
                        if (!$moduleInstalled) {
                            $missingModule = Module::findOne($dependency);
                            if ($missingModule) {
                                $dependencies[] = Yii::t('module', $missingModule->name);
                            }
                        }
                    }
                }
            }
        }
        return $dependencies;
    }

    public function dependants() {
        $dependants = [];
        $organization = Organization::findOne(Yii::$app->user->identity->selectedOrganization->id);
        if ($organization) {
            foreach ($organization->organizationModuleRelations as $cMR) {
                if ($cMR->module->additional_data !== null) {
                    $additional_data = json_decode($cMR->module->additional_data);
                    if (isset($additional_data->dependencies)) {
                        foreach ($additional_data->dependencies as $dependency) {
                            if ($dependency === $this->id){
                                $dependants[] = Yii::t('module', $cMR->module->name);
                            }
                        }
                    }
                }
            }
        }
        return $dependants;
    }

}
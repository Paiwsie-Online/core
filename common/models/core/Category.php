<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use lajax\translatemanager\helpers\Language;

/**
 * @property string $category_id
 * @property string $name
 * @property string $description
 */

class Category extends \yii\db\ActiveRecord {

    public $name_t;
    public $description_t;

    public function afterFind() {
        $this->name_t = Language::d($this->name);
        $this->description_t = Language::d($this->descrioption);
        parent::afterFind();
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            Language::saveMessage($this->name);
            Language::saveMessage($this->description);
            return true;
        }

        return false;
    }

    public function getName($params = [], $language = null) {
        return Language::d($this->name, $params, $language);
    }

    public function getDescription($params = [], $language = null) {
        return Language::d($this->description, $params, $language);
    }

}
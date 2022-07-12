<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property int $id
 * @property int|null $parent
 * @property string|null $enumerator
 * @property string[] $enumerators
 * @property string|null $value
 * @property Enumeration $parent0
 * @property Enumeration[] $enumerations
 * @property Enumeration[] $childs
 * @property int|null $ownerLevel
 */

class Enumeration extends \yii\db\ActiveRecord {

    public $parentvalue;
    //public $ownerLevel;

    public static function tableName() {
        return 'enumeration';
    }

    public function rules() {
        return [
            [['enumerator'], 'required'],
            [['parent'], 'integer'],
            [['parentvalue', 'ownerLevel'], 'safe'],
            [['value'], 'string'],
            [['enumerator'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'parent' => Yii::t('core_model', 'Parent'),
            'parentvalue' => Yii::t('core_model', 'Parent'),
            'enumerator' => Yii::t('core_model', 'Enumerator'),
            'value' => Yii::t('core_model', 'Value'),
        ];
    }

    public function extraFields() {
        return [
            'childs',
        ];
    }

    // RETURNS THE LIST OF A SPECIFIED CODE
    public static function get_list($code, $id = null) {
        $query = Enumeration::find()->where(['enumerator' => $code, 'parent' => $id ])->orderBy(['value' => SORT_ASC]);
        $temp_list = $query->all();
        return ArrayHelper::map($temp_list, 'id', 'value');
    }

    // GET CHILDS IF THE CURRENT ENUMERATION HAVE SOME
    public function getChilds() {
        return Enumeration::find()->where(['parent' => $this->id ])->all();
    }

    // GET LIST OF ENUMERATORS PRESENT IN ENUMERATION TABLE
    public static function getEnumerators() {
        $returnList = Enumeration::find()->select('enumerator')->groupBy('enumerator')->asArray()->all();
        return $returnList;
    }

    // GET THE VALUE OF THE PARENT IF HAVE ONE
    public static function getParentvalue($id) {
        $parentInfo = Enumeration::findOne($id);
        if ($parentInfo) {
            return $parentInfo->value;
        }
        return null;
    }

    // SEARCH IN ENUMERATION TABLE THE ID ASSIGNED TO THE OWNER LEVEL
    // TODO: ADD THAT THE VALUE MUST BE OF LEVEL -> OWNER
    public static function getOwnerLevel() {
        $returnValue = Enumeration::findOne(['enumerator' => 'object_participant_level'/*, 'value' => '%"level":"owner"%'*/]);
        if ($returnValue) {
            return $returnValue->id;
        } else {
            return null;
        }
    }

}
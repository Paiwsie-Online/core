<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class EnumerationSearch extends Enumeration {

    public $parentvalue;

    public function rules() {
        return [
            [['id', 'parent'], 'integer'],
            [['enumerator', 'value', 'parentvalue'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = Enumeration::find()->select(['enumeration.*', 'e.value as parentvalue'])->leftJoin('enumeration e', 'enumeration.parent=e.id');
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere(['like', 'enumeration.enumerator', $this->enumerator])
            ->andFilterWhere(['like', 'enumeration.value', $this->value])
            ->andFilterWhere(['like', 'e.value', $this->parentvalue])
            ->andFilterWhere(['like', 'enumeration.id', $this->id]);
        return $dataProvider;
    }

}
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrganizationUsergroupUserRelationSearch extends OrganizationUsergroupUserRelation {

    public function rules() {
        return [
            [['id', 'ou_relation_id', 'group_id', 'added_by'], 'integer'],
            [['added'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = OrganizationUsergroupUserRelation::find();
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
        $query->andFilterWhere([
            'id' => $this->id,
            'ou_relation_id' => $this->ou_relation_id,
            'group_id' => $this->group_id,
            'added_by' => $this->added_by,
            'added' => $this->added,
        ]);
        return $dataProvider;
    }

}
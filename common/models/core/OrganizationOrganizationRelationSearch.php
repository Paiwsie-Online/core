<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrganizationOrganizationRelationSearch extends OrganizationOrganizationRelation {

    public function rules() {
        return [
            [['id', 'parent_organization', 'child_organization', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = OrganizationOrganizationRelation::find();
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
            'parent_organization' => $this->parent_organization,
            'child_organization' => $this->child_organization,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ]);
        return $dataProvider;
    }

}
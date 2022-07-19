<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrganizationUserModuleRightSearch extends OrganizationUserModuleRight {

    public function rules() {
        return [
            [['id', 'ou_relation_id', 'cmr_id', 'right_create', 'right_read', 'right_update', 'right_delete', 'created_by'], 'integer'],
            [['created_at', 'updated_by', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = OrganizationUserModuleRight::find();
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
            'cmr_id' => $this->cmr_id,
            'right_create' => $this->right_create,
            'right_read' => $this->right_read,
            'right_update' => $this->right_update,
            'right_delete' => $this->right_delete,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);
        return $dataProvider;
    }

}
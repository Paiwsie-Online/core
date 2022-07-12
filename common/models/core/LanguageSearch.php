<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class LanguageSearch extends Language {

    public function rules() {
        return [
            [['id', 'language', 'country', 'name', 'name_ascii', 'status'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = Language::find();
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
        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'name_ascii', $this->name_ascii])
            ->andFilterWhere(['like', 'status', $this->status]);
        return $dataProvider;
    }

}
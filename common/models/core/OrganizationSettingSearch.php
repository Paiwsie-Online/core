<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrganizationSettingSearch extends OrganizationSetting {

    public function rules() {
        return [
            [['organization_id'], 'integer'],
            [['setting', 'value'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = OrganizationSetting::find();
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
            'organization_id' => $this->organization_id,
        ]);
        $query->andFilterWhere(['like', 'setting', $this->setting])
            ->andFilterWhere(['like', 'value', $this->value]);
        return $dataProvider;
    }

}
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SystemContentSearch extends SystemContent {

    public function rules() {
        return [
            [['content', 'value', 'instance'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = SystemContent::find();
        // add conditions that should always apply here
        $query->orderBy('instance ASC, content ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if (!Yii::$app->user->identity->hasAccess('systemAdmin', 'read')) {
            $this->instance = Yii::$app->params['default_site_settings']['instance'];
        }
        // grid filtering conditions
        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'instance', $this->instance]);
        return $dataProvider;
    }

}
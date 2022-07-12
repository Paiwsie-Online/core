<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\core\CronjobLog;

class CronjobLogSearch extends CronjobLog {

    public function rules() {
        return [
            [['id', 'cronjob_id'], 'integer'],
            [['started', 'ended', 'data'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = CronjobLog::find();

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
            'cronjob_id' => $this->cronjob_id,
            'started' => $this->started,
            'ended' => $this->ended,
        ]);

        $query->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }

}
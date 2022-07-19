<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\core\SiteadminApiKey;

class SiteadminApiKeySearch extends SiteadminApiKey {

    public function rules() {
        return [
            [['id', 'key_id', 'right_create', 'right_read', 'right_update', 'right_delete', 'created_by'], 'integer'],
            [['module_id', 'created_at'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = SiteadminApiKey::find();

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
            'key_id' => $this->key_id,
            'right_create' => $this->right_create,
            'right_read' => $this->right_read,
            'right_update' => $this->right_update,
            'right_delete' => $this->right_delete,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'module_id', $this->module_id]);

        return $dataProvider;
    }

}
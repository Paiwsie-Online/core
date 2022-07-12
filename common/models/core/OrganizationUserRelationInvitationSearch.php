<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrganizationUserRelationInvitationSearch extends OrganizationUserRelationInvitation {

    public function rules() {
        return [
            [['id', 'our_id'], 'integer'],
            [['sent_via', 'sent_to', 'cid'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = OrganizationUserRelationInvitation::find();
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
            'our_id' => $this->our_id,
        ]);
        $query->andFilterWhere(['like', 'sent_via', $this->sent_via])
            ->andFilterWhere(['like', 'sent_to', $this->sent_to])
            ->andFilterWhere(['like', 'cid', $this->cid]);
        return $dataProvider;
    }

}
<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrganizationUserRelationSearch extends OrganizationUserRelation {

    public $user_full_name;
    public $added_by_full_name;
    public $addedStart;
    public $addedEnd;

    public function rules() {
        return [
            [['id', 'organization_id', 'user_id', 'added_by'], 'integer'],
            [['user_full_name', 'added_by_full_name', 'title', 'user_level', 'added', 'status', 'status_changed', 'addedStart', 'addedEnd'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        //$query = OrganizationUserRelation::find();
        $query = OrganizationUserRelation::find()->select(['organization_user_relation.*', 'concat(u.first_name,SPACE(1),u.last_name) as user_full_name', 'concat(u2.first_name,SPACE(1),u2.last_name) as added_by_full_name'])->leftJoin('user u','u.id=user_id')->leftJoin('user u2', 'u2.id=added_by');
        // add conditions that should always apply here
        $query->orderBy('user_full_name ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' =>  [
                'user_full_name',
                'title',
                'added_by_full_name',
                'user_level',
                'added',
                'status',
                'status_changed'
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if (!Yii::$app->user->identity->hasAccess('systemAdmin', 'read')) {
            $this->organization_id = Yii::$app->user->identity->selectedOrganization['id'];
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'user_id' => $this->user_id,
            'added_by' => $this->added_by,
            'user_level' => $this->user_level,
            'organization_user_relation.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'added', $this->added])
            ->andFilterWhere(['like', 'status_changed', $this->status_changed])
            ->andFilterWhere(['like', 'concat(u.first_name,SPACE(1),u.last_name)', $this->user_full_name])
            ->andFilterWhere(['like', 'concat(u2.first_name,SPACE(1),u2.last_name)', $this->added_by_full_name]);
        return $dataProvider;
    }

    public function searchList($params) {
        //$query = OrganizationUserRelation::find();
        $query = OrganizationUserRelation::find()->select(['organization_user_relation.*', 'concat(u.first_name,SPACE(1),u.last_name) as user_full_name', 'concat(u2.first_name,SPACE(1),u2.last_name) as added_by_full_name'])->leftJoin('user u','u.id=user_id')->leftJoin('user u2', 'u2.id=added_by');
        // add conditions that should always apply here
        $query->orderBy('user_full_name ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' =>  [
                'user_full_name',
                'title',
                'added_by_full_name',
                'user_level',
                'added',
                'status',
                'status_changed'
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $this->organization_id = Yii::$app->user->identity->selectedOrganization['id'];
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'user_id' => $this->user_id,
            'user_level' => $this->user_level,
            'organization_user_relation.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'added', $this->added])
            ->andFilterWhere(['like', 'status_changed', $this->status_changed])
            ->andFilterWhere(['like', 'concat(u.first_name,SPACE(1),u.last_name)', $this->user_full_name])
            ->andFilterWhere(['like', 'concat(u2.first_name,SPACE(1),u2.last_name)', $this->added_by_full_name]);
        $query->andFilterWhere(['>=', 'added', $this->addedStart])
            ->andFilterWhere(['<', 'added', date('Y-m-d H:i:s', strtotime($this->addedEnd . "+ 1 day"))]);
        return $dataProvider;
    }

}
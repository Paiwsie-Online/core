<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrganizationUsergroupSearch extends OrganizationUsergroup {

    public $created_by_full_name;
    public $createdStart;
    public $createdEnd;

    public function rules() {
        return [
            [['id', 'organization_id', 'created_by'], 'integer'],
            [['created_by_full_name', 'name', 'created', 'createdStart', 'createdEnd'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        //$query = OrganizationUsergroup::find();
        $query = OrganizationUsergroup::find()->select(['organization_usergroup.*', 'concat(user.first_name,SPACE(1),user.last_name) as created_by_full_name'])->leftJoin('user','user.id=created_by');
        // add conditions that should always apply here
        $query->orderBy('name ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  =>  ['defaultOrder' => ['organization_usergroup.name' => SORT_ASC]],
        ]);
        $dataProvider->setSort([
            'attributes' =>  [
                'id',
                'organization_id',
                'name',
                'created_by_full_name',
                'created'
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
            'created_by' => $this->created_by,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'concat(u.first_name,SPACE(1),u.last_name)', $this->created_by_full_name])
            ->andFilterWhere(['like', 'created', strtotime($this->created)]);
        return $dataProvider;
    }

    public function searchList($params) {
        //$query = OrganizationUsergroup::find();
        $query = OrganizationUsergroup::find()->select(['organization_usergroup.*', 'concat(user.first_name,SPACE(1),user.last_name) as created_by_full_name'])->leftJoin('user','user.id=created_by');
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  =>  ['defaultOrder' => ['organization_usergroup.name' => SORT_ASC]],
        ]);
        $dataProvider->setSort([
            'attributes' =>  [
                'id',
                'organization_id',
                'name',
                'created_by_full_name',
                'created'
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
            //'created_by' => $this->created_by,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'concat(user.first_name,SPACE(1),user.last_name)', $this->created_by_full_name])
            ->andFilterWhere(['like', 'created', $this->created]);
        $query->andFilterWhere(['>=', 'created', strtotime($this->createdStart)])
            ->andFilterWhere(['<', 'created', strtotime($this->createdEnd . "+ 1 day")]);
        return $dataProvider;
    }

}
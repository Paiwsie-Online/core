<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrganizationSearch extends Organization {

    public $created_by_full_name;
    public $createdStart;
    public $createdEnd;

    public function rules() {
        return [
            [['id', 'created_by'], 'integer'],
            [['created_by_full_name', 'name', 'tax_number', 'instance', 'created', 'createdStart', 'createdEnd'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        //$query = Organization::find();
        $query = Organization::find()->select(['organization.*', 'concat(user.first_name,SPACE(1),user.last_name) as created_by_full_name'])->leftJoin('user', 'user.id=organization.created_by');
        // add conditions that should always apply here
        $query->orderBy('name ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' =>  [
                'id',
                'name',
                'tax_number',
                'created_by',
                'created',
                'instance',
                'created_by_full_name'
            ]
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
        $query->andFilterWhere([
            'organization.id' => $this->id,
            'organization.instance'  =>  $this->instance,
        ]);
        $query->andFilterWhere(['like', 'organization.name', $this->name])
            ->andFilterWhere(['like', 'organization.tax_number', $this->tax_number])
            ->andFilterWhere(['like', 'organization.created_by', $this->created_by])
            ->andFilterWhere(['like', 'organization.created', $this->created])
            ->andFilterWhere(['like', 'concat(user.first_name,SPACE(1),user.last_name)', $this->created_by_full_name]);
        $query->andFilterWhere(['>=', 'organization.created', strtotime($this->createdStart)])
            ->andFilterWhere(['<', 'organization.created', strtotime($this->createdEnd . "+ 1 day")]);
        return $dataProvider;
    }

    public function searchAffiliates($params) {
        $queryAffiliates = OrganizationModuleRelation::find()->select(['organization_id'])->where(['module_id' => 'affiliate']);
        $query = Organization::find()->select(['organization.*'])->leftJoin(['sq' => $queryAffiliates], 'sq.organization_id=organization.id')->where('sq.organization_id=organization.id');
        $query->orderBy('name ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' =>  [
                'name',
                'created',
                'instance',
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'instance'  =>  $this->instance,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['>=', 'created', strtotime($this->createdStart)])
            ->andFilterWhere(['<', 'created', strtotime($this->createdEnd . "+ 1 day")]);
        return $dataProvider;
    }

}
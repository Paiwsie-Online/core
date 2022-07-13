<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends User {

    public $full_name;
    public $registeredStart;
    public $registeredEnd;

    public function rules() {
        return [
            [['id'], 'integer'],
            [['full_name', 'first_name', 'last_name', 'country', 'pnr', 'email', 'email_status', 'password', 'status', 'registered', 'auth_key', 'access_token', 'instance', 'phone', 'phone_status', 'registeredStart', 'registeredEnd'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    // INDEX PAGE
    public function search($params) {
        $query = User::find()->select(['*', 'concat(first_name,SPACE(1),last_name) as full_name']);
        $query->orderBy('full_name ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
           'attributes' =>  [
               'full_name',
               'country',
               'pnr',
               'email',
               'email_status',
               'status',
               'registered',
               'instance'
           ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        if (!Yii::$app->user->identity->hasAccess('systemAdmin', 'read')) {
            $this->instance = Yii::$app->params['default_site_settings']['instance'];
        }
        $query->andFilterWhere([
            'country'   =>  $this->country,
            'email_status' => $this->email_status,
            'status'    =>  $this->status,
            'instance'  =>  $this->instance
        ]);
        $query->andFilterWhere(['like', 'pnr', $this->pnr])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'registered', $this->registered])
            ->andFilterWhere(['like', 'concat(first_name,SPACE(1),last_name)', $this->full_name]);
        $query->andFilterWhere(['>=', 'registered', strtotime($this->registeredStart)])
            ->andFilterWhere(['<', 'registered', strtotime($this->registeredEnd . "+ 1 day")]);
        return $dataProvider;
    }

    // FRONTEND USER PAGE
    public function searchFrontendUsers($params) {
        $frontendInstance = OrganizationSetting::findOne(['organization_id' => Yii::$app->user->identity->selectedOrganization->id, 'setting' => 'frontendInstance']);
        $query = User::find()->select(['*', 'concat(first_name,SPACE(1),last_name) as full_name'])->where(['instance' => $frontendInstance->value]);
        $query->orderBy('full_name ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' =>  [
                'full_name',
                'email',
                'email_status',
                'phone',
                'phone_status',
                'registered'
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'phone_status' => $this->phone_status,
            'email_status' => $this->email_status,
        ]);
        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'concat(first_name,SPACE(1),last_name)', $this->full_name]);
        $query->andFilterWhere(['>=', 'registered', strtotime($this->registeredStart)])
            ->andFilterWhere(['<', 'registered', strtotime($this->registeredEnd . "+ 1 day")]);
        return $dataProvider;
    }

}
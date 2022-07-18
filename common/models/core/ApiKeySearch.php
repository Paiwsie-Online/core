<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\core\ApiKey;

class ApiKeySearch extends ApiKey {

    public $created_by_full_name;
    public $createdStart;
    public $createdEnd;

    public function rules() {
        return [
            [['id', 'organization_id', 'created_by'], 'integer'],
            [['key_type', 'key', 'instance', 'created_at', 'key_config', 'expiry_date', 'status', 'type', 'created_by_full_name', 'createdStart', 'createdEnd'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    // INDEX SITE ADMIN PAGE
    public function search($params) {
        $query = ApiKey::find()->select(['api_key.*', 'concat(u.first_name,SPACE(1),u.last_name) as created_by_full_name'])->leftJoin('user u', 'u.id=created_by')->where(['api_key.instance' => Yii::$app->user->identity->instance]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  =>  ['defaultOrder' => ['api_key.id' => SORT_DESC]],
        ]);
        $dataProvider->setSort([
            'attributes' =>  [
                'key_type',
                'instance',
                'created_at',
                'expiry_date',
                'status',
                'type',
                'created_by_full_name',
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'key_type', $this->key_type])
            ->andFilterWhere(['like', 'api_key.instance', $this->instance])
            ->andFilterWhere(['like', 'api_key.status', $this->status])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'expiry_date', $this->expiry_date])
            ->andFilterWhere(['like', 'concat(u.first_name,SPACE(1),u.last_name)', $this->created_by_full_name]);
        $query->andFilterWhere(['>=', 'created_at', strtotime($this->createdStart)])
            ->andFilterWhere(['<', 'created_at', strtotime($this->createdEnd . "+ 1 day")]);
        return $dataProvider;
    }

    // INDEX ORGANIZATION PAGE
    public function searchOrganization($params) {
        $query = ApiKey::find()->select(['api_key.*', 'concat(u.first_name,SPACE(1),u.last_name) as created_by_full_name'])->leftJoin('user u', 'u.id=created_by')->where(['api_key.instance' => Yii::$app->user->identity->instance, 'key_type' => 'organization', 'api_key.organization_id' => Yii::$app->user->identity->selectedOrganization->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  =>  ['defaultOrder' => ['api_key.id' => SORT_DESC]],
        ]);
        $dataProvider->setSort([
            'attributes' =>  [
                'key_type',
                'created_at',
                'expiry_date',
                'status',
                'type',
                'created_by_full_name',
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'key_type', $this->key_type])
            ->andFilterWhere(['like', 'api_key.status', $this->status])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'expiry_date', $this->expiry_date])
            ->andFilterWhere(['like', 'concat(u.first_name,SPACE(1),u.last_name)', $this->created_by_full_name]);
        $query->andFilterWhere(['>=', 'created_at', strtotime($this->createdStart)])
            ->andFilterWhere(['<', 'created_at', strtotime($this->createdEnd . "+ 1 day")]);
        return $dataProvider;
    }

}

<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SystemLogSearch extends SystemLog {

    public $organization_name;
    public $user_name;

    public function rules() {
        return [
            [['id', 'user_id', 'organization_id'], 'integer'],
            [['message_short', 'message', 'data_format', 'created_at', 'instance', 'organization_name', 'user_name'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        //$query = SystemLog::find();
        $query = SystemLog::find()->select(['system_log.*', 'c.name as organization_name', 'concat(u.first_name,SPACE(1),u.last_name) as user_name'])->leftJoin('organization c', 'c.id=system_log.organization_id')->leftJoin('user u', 'u.id=system_log.user_id');
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  =>  ['defaultOrder' => ['system_log.id' => SORT_DESC]],
        ]);
        $dataProvider->setSort([
            'attributes' =>  [
                'id',
                'user_id',
                'organization_id',
                'message_short',
                'message',
                'data_format',
                'created_at',
                'instance',
                'organization_name',
                'user_name',
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'u.instance'  =>  $this->instance
        ]);
        $query->andFilterWhere(['like', 'message_short', $this->message_short])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'data_format', $this->data_format])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'organization_id', $this->organization_id])
            ->andFilterWhere(['like', 'organization.name', $this->organization_name])
            ->andFilterWhere(['like', 'concat(u.first_name,SPACE(1),u.last_name)', $this->user_name]);
        return $dataProvider;
    }

}
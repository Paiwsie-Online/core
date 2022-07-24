<?php

namespace common\models\core;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\core\UserNotificationRelation;

/**
 * UserNotificationRelationSearch represents the model behind the search form of `common\models\core\UserNotificationRelation`.
 */
class UserNotificationRelationSearch extends UserNotificationRelation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notification_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserNotificationRelation::find();

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
            'notification_id' => $this->notification_id,
            'user_id' => $this->user_id,
        ]);

        return $dataProvider;
    }
}

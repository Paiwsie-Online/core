<?php

namespace common\models\core;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\core\Notification;

/**
 * NotificationSearch represents the model behind the search form of `common\models\core\Notification`.
 */
class NotificationSearch extends Notification
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_changed', 'status_changed_by', 'created_at'], 'integer'],
            [['category', 'priority', 'notification_data', 'status'], 'safe'],
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
        $query = Notification::find();

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
            'status_changed' => $this->status_changed,
            'status_changed_by' => $this->status_changed_by,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'priority', $this->priority])
            ->andFilterWhere(['like', 'notification_data', $this->notification_data])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}

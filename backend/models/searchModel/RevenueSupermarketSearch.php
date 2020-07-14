<?php

namespace backend\models\searchModel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\RevenueSupermarket;

/**
 * RevenueSupermarketSearch represents the model behind the search form of `backend\models\RevenueSupermarket`.
 */
class RevenueSupermarketSearch extends RevenueSupermarket
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'daily_revenue'], 'integer'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = RevenueSupermarket::find();

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
            'daily_revenue' => $this->daily_revenue,
            'selected_date' => $this->selected_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}

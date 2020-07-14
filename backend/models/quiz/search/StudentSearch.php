<?php

namespace backend\models\quiz\search;

use backend\models\quiz\Students;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StudentSearch represents the model behind the search form of `app\models\StudentsCrud`.
 */
class StudentSearch extends Students
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'correct_answer', 'wrong_answer', 'score', 'is_complete'], 'integer'],
            [['token', 'name', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Students::find();

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
            'correct_answer' => $this->correct_answer,
            'wrong_answer' => $this->wrong_answer,
            'score' => $this->score,
            'is_complete' => $this->is_complete,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}

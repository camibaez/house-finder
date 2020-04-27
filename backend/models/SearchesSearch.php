<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Searches;

/**
 * SearchesSearch represents the model behind the search form about `backend\models\Searches`.
 */
class SearchesSearch extends Searches
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price_min', 'price_max', 'images_only', 'created_at'], 'integer'],
            [['value', 'terms', 'sites'], 'safe'],
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
        $query = Searches::find();

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
            'price_min' => $this->price_min,
            'price_max' => $this->price_max,
            'images_only' => $this->images_only,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'terms', $this->terms])
            ->andFilterWhere(['like', 'sites', $this->sites]);

        $query->groupBy("hash");
        $query->orderBy("created_at DESC");
        return $dataProvider;
    }
}

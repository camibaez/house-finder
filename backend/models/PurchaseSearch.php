<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Purchase;

/**
 * PurchaseSearch represents the model behind the search form about `common\models\Purchase`.
 */
class PurchaseSearch extends Purchase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bedroom_min', 'bathroom_min', 'created_at', 'updated_at', 'status'], 'integer'],
            [['price_min', 'price_desired', 'price_max', 'area_min', 'area', 'area_max'], 'number'],
            [['user_username', 'description'], 'safe'],
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
        $query = Purchase::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'price_min' => $this->price_min,
            'price_desired' => $this->price_desired,
            'price_max' => $this->price_max,
            'bedroom_min' => $this->bedroom_min,
            'bathroom_min' => $this->bathroom_min,
            'area_min' => $this->area_min,
            'area' => $this->area,
            'area_max' => $this->area_max,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user_username', $this->user_username])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}

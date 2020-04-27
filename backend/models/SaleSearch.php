<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Sale;

/**
 * SaleSearch represents the model behind the search form about `common\models\Sale`.
 */
class SaleSearch extends Sale
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bedroom', 'bathroom', 'province_id', 'municipality_id', 'neighborhood_id', 'zone_id', 'house_type_id', 'created_at', 'updated_at', 'status', 'expiration_status'], 'integer'],
            [['price', 'price_max', 'area', 'rank'], 'number'],
            [['address', 'user_username', 'description'], 'safe'],
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
        $query = Sale::find();

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
            'price' => $this->price,
            'price_max' => $this->price_max,
            'bedroom' => $this->bedroom,
            'bathroom' => $this->bathroom,
            'area' => $this->area,
            'province_id' => $this->province_id,
            'municipality_id' => $this->municipality_id,
            'neighborhood_id' => $this->neighborhood_id,
            'zone_id' => $this->zone_id,
            'house_type_id' => $this->house_type_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'expiration_status' => $this->expiration_status,
            'rank' => $this->rank,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'user_username', $this->user_username])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}

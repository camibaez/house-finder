<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 04/03/2017
 * Time: 0:20
 */

namespace backend\models;




use common\models\User as CommonUser;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends User{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['username', 'displayname', 'email', 'status', 'contact'], 'safe']
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
        $query = CommonUser::find()->where(["not", ['status' => User::STATUS_ADMIN]]);


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
            'status' => $this->status,

        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'displayname', $this->displayname])
            ->andFilterWhere(['like', 'email', $this->email]);
           // ->andFilterWhere(['like', 'ip', $this->ip]);


        return $dataProvider;
    }
} 
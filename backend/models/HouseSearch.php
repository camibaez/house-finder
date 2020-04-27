<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\models;

use common\models\House;

use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * Description of HouseSearch
 *
 * @author User
 */
class HouseSearch extends \common\models\HouseSearch{
     public function search($params, $asArray = false) {
        $query = (new Query())->from("house");
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 16,
            ],
        ]);

        $this->load($params);
        $this->loadGlobalValues();

        if (!$this->validate()) {
            $query->where("1=0");
            return $dataProvider;
        }

        $cleanTerms = $this->cleanTerms;
        $locations = $this->getNormalizedLocations($cleanTerms);
        
        $rankFunctions = [];
        
        $this->locationsSetup($locations, $rankFunctions);
        $this->priceSetup($query, $rankFunctions);


        $selectParameters = ["*"];
        if ($rankFunctions)
            $selectParameters[] = "(" . implode("+", $rankFunctions) . " + rank) AS r_rank";
        else
            $rankFunctions[] = "rank AS r_rank";
        $query->select($selectParameters);

        $query->where(['status' => House::SAFE_STATUS]);
        $query->andFilterWhere(['>=', 'price', $this->priceMin]);
        $query->andFilterWhere(['<=', 'price', $this->priceMax]);
        $query->andFilterWhere(["OR",
            ['or like', 'title', $locations],
            ['like', 'description', $locations]
        ]);

        $this->loadSitesList();
        if ($this->checkSitesDiff())
            $query->andWhere(['site_id' => $this->sites]);


        $query->orderBy('r_rank DESC');

        return $dataProvider;
    }
}

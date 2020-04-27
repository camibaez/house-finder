<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 27/02/2017
 * Time: 19:05
 */

namespace common\components\evaluator;


use common\models\Sale;

class SaleEvaluator {
    public function run($mod = null, $val = null){
        $this->evaluateAllSales($mod, $val);
    }

    public function evaluateAllSales($mod = null, $val = null){
        $salesRankMap = [];
        $query = Sale::find()->where(['status' =>Sale::ACTIVE_STATUS]);

        if($mod != null)
            $query->andWhere("(id % $mod = $val)");

        $commitCount = 100;
        $i = 0;
        $transaction = \Yii::$app->db->beginTransaction();
        foreach ($query->each(100) as $sale) {
            $rank = $this->evaluateHouse($sale);

            \Yii::$app->db->createCommand()->update(Sale::tableName(), ['rank' => $rank], ['id' => $sale->id])->execute();
            $i += 1;
            if($i >= $commitCount){
                $transaction->commit();
                $transaction = \Yii::$app->db->beginTransaction();
            }
        }
        $transaction->commit();

    }


    /**
     * @param $sale Sale
     */
    public function evaluateHouse($sale){
        $rank = 0;

        //IMAGE EVALUATION MAX = 2
        $imageFactor = 2.0 / 3.0;
        $imageEvaluation = $sale->getViewImages()->count() * $imageFactor;
        $rank += $imageEvaluation;

        //DESCRIPTION EVALUATION MAX = 1
        $commentsEvaluation = $sale->description !== ""? 1 : 0;
        $rank += $commentsEvaluation;

        //TIME EVALUATION MAX = 1.5
        //$timeEvaluation = $this->timeEvaluator($sale);
        //$rank += $timeEvaluation;

        //DIRECTION EVALUATION MAX = 0.25
        $directionEvaluation = $sale->address !== ""? 0.25 : 0;
        $rank += $directionEvaluation;

        //AREA EVALUATION MAX = 0.25
        $areaEvaluation = $sale->area? 0.25 : 0;
        $rank += $areaEvaluation;

        return $rank;

    }




    public function timeEvaluator($sale){
        $oneMonth = 60 * 60 * 24 * 30;
        $threeMonth = $oneMonth * 3;

        $m = -1.5 / $threeMonth;

        return $m * (time() - $sale->updated_at) + 1.5;
    }

} 
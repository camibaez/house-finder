<?php

/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 06/08/2016
 * Time: 1:10
 */

namespace console\controllers;

use common\components\evaluator\SaleEvaluator;
use common\components\matchmaker\MailAgent;
use common\components\matchmaker\MatchingAgent;
use common\components\matchmaker\MatchMaker;
use common\components\matchmaker\Populator;
use yii\console\Controller;

class ManageController extends Controller {

    public function actionLoadImages($site = null, $onlynull = true) {
        $query = (new \yii\db\Query())
                ->from('house')
                ->innerJoin('sale_image', "house.id = sale_image.sale_id")
                ->select(["house.id", "sale_image.url", "RAND() * 10 AS rander"])
                //->andFilterWhere(['site_id' => $site])
                ->andWhere(['status' => \common\models\House::SAFE_STATUS, 'reviewed' => 0, 'thumb_loaded' => 0]);


        if ($onlynull)
            $query->andWhere(['OR', ['thumb' => null], ['=', '(LENGTH(thumb))', 0]]);

        $query->groupBy('house.id');
        $query->orderBy('rander ASC');

        //echo $query->createCommand()->rawSql;
        //exit;
        $success = 0;
        $fail = 0;
        $total = $query->count();
        echo $total;

        echo $query->createCommand()->rawSql;
        
        foreach ($query->each() as $house) {
            $id = $house['id'];
            $url = $house['url'];
            if (empty($url) || $url == null)
                continue;
            try {
                $imageData = file_get_contents($url);
                \Yii::$app->db->createCommand()
                        ->update('house', ['thumb' => $imageData, 'thumb_loaded' => 1, 'thumb_compressed' => 0], ['id' => $id])
                        ->execute();
                $success++;
            } catch (\Exception $ex) {
                echo "ERROR\n";
                echo $ex;
                $fail++;
            }


            $percent = ($success + $fail) / $total * 100;
            echo "Progress: $percent%\n";
        }
        $sPercent = $success / $total * 100;
        $fPercent = $fail / $total * 100;
        echo "Finished. Success: $sPercent%; Fail: $fPercent";
    }

    public function actionPopulateHouses($count = 20000) {
        $initTime = time();
        echo "Init time: " . $initTime . " s\n";
        Populator::populateHouses();
        echo "\nFinish Time: " . time() . " s\n";
        echo "Elapsed: " . (time() - $initTime);
    }

    public function actionCleanHouses() {
        static::actionCleanTable('house');
    }

    public function actionCleanTable($tableName) {
        \Yii::$app->db->createCommand("DELETE FROM $tableName WHERE 1")->execute();
    }

    public function actionExtractData() {
        (new \common\components\extractor\ExtractorController())->extractData();
    }

    public function actionRunEvaluationAgent($mod = null, $val = null) {
        $time = time();
        (new SaleEvaluator())->run($mod, $val);
        echo "Time: " . (time() - $time) . "s";
    }

}

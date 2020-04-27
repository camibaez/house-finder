<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 10/08/2016
 * Time: 23:12
 */

namespace common\components\matchmaker;


use common\models\House;
use common\models\Purchase;
use common\models\PurchaseExtensionModel;
use common\models\Sale;
use common\models\User;
use Faker\Factory;
use yii\db\Query;

class Populator
{
    public static function populateHouses($count = 10000)
    {

        $tree = self::getMunicipalitiesId();
        $ntree = self::getNeigh();

        //$sleepTime = 4;

        $faker = Factory::create();
        $commitCount = 500;

        $housesList = [];


        for ($i = 1; $i < $count; $i++) {
            $model = new House();

            $model->price = $faker->numberBetween(10000, 80000);
            $model->address = $faker->boolean() ? $faker->address : null;
            $model->bedroom = $faker->boolean() ? $faker->numberBetween(1, 6) : null;
            $model->bathroom = $faker->boolean() ? $faker->numberBetween(1, $model->bedroom + 1) : null;
            $model->area = $faker->boolean() ? $faker->numberBetween(50, 200) : null;

            $model->province_id = $faker->boolean() ? $faker->numberBetween(1, 3) : null; //Habana, Pinar, Matanza, Isla

            $model->municipality_id = null;
            if($model->province_id){
                $mun = $tree[$model->province_id];
                $model->municipality_id = $mun[array_rand($mun)];
            }

            $model->neighborhood_id = null;
            if($model->municipality_id){
                $neigh = $ntree[$model->municipality_id];
                if ($neigh) {
                    $model->neighborhood_id = $neigh[array_rand($neigh)];
                } else {
                    $model->neighborhood_id = null;
                }
            }

            $model->zone_id = $faker->boolean() ? $faker->numberBetween(1, 2) : null;
            $model->house_type_id = $faker->boolean() ? $faker->numberBetween(1, 2) : null;
            $model->created_at = time();
            $model->updated_at = time();
            $model->description = $faker->boolean() ? $faker->paragraph : null;
            $model->title = $faker->sentence(6);
            $model->url = $faker->url;
            $model->site_id = "Revolico";
            $model->id = $i;

            $model->calculateRank();
            $housesList[] = array_values($model->dirtyAttributes);


            if ($i % $commitCount == 0) {
                \Yii::$app->db->createCommand()->batchInsert('house', array_keys($model->dirtyAttributes), $housesList)->execute();
                $housesList = [];
                echo "\nCommited $commitCount \nSleeping... \n";

            }

        }

    }



    protected static function getMunicipalitiesId()
    {
        $tree = [1 => [], 2 => [], 3 => []];
        foreach ($tree as $prov => $muns) {
            $res = (new Query())->from('municipality')->select('id')->where(['province_id' => $prov])->indexBy('id')->all();

            $res = array_keys($res);
            $tree[$prov] = $res;
        }


        return $tree;
    }

    protected static function getNeigh()
    {
        $tree = [];

        for ($i = 1; $i <= 179; $i++) {
            $tree[$i] = [];
        }

        foreach ($tree as $prov => $muns) {
            $res = (new Query())->from('neighborhood')->select('id')->where(['municipality_id' => $prov])->indexBy('id')->all();
            if (!$res)
                continue;
            $res = array_keys($res);
            $tree[$prov] = $res;
        }

        return $tree;
    }




    protected static function generateLocations($values)
    {
        $faker = Factory::create();
        $values = $faker->shuffleArray($values);
        $newValues = [];
        for ($i = 0; $i < rand(1, count($values)); $i++)
            $newValues[] = $values[$i];
        return $values[0];

    }

}
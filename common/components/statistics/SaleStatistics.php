<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 23/4/16
 * Time: 11:13
 */

namespace common\components\statistics;


use yii\db\Query;
use yii\helpers\Json;

class SaleStatistics
{

    /** Calcula los porciento de ventas en un rango de precios
     * @param $max
     * @param $min
     * @param $intervals
     * @return array Devuelve [[promedioRango, porcientoVenta], [...], ...]
     */
    public function priceRangePercents($min, $max, $intervals)
    {
        $range = ($max - $min) / $intervals;
        $tempMax = $min + $range;
        $average = [];

        $generalQuery = (new Query())
            ->select('COUNT(*)')
            ->from('sale')
            ->where(['between', 'price', $min, $max]);

        $parcialQuery = (new \yii\db\query())
            ->select('COUNT(*)')
            ->from('sale')
            ->where(['between', 'price', $min, $tempMax]);

        $generalQuery->union($parcialQuery);

        array_push($average, ($min + $tempMax) / 2);
        $tempMin = $tempMax;
        $tempMax = $tempMax + $range;

        $count = 1;


        while ($tempMax <= $max) {
            $count++;
            $parcialQuery = (new Query())
                ->select('COUNT(*)')
                ->from('sale')
                ->where(['between', 'price', $tempMin, $tempMax]);

            $generalQuery->union($parcialQuery, true);

            array_push($average, ($tempMin + $tempMax) / 2);

            $tempMin = $tempMax;
            if ($count === $intervals - 1) {
                $tempMax = $max;
            } else {
                $tempMax = $tempMax + $range;
            }

        }

        $resultQuery = $generalQuery->all();

        $result = [];
        $index = -1;
        $total = 0;

        foreach ($resultQuery as $item) {
            //QUITA ESTO. ELIMINA EL TOTAL DEL ARREGLO ANTES DE METERTE EN EL FOR. Asi no tienes que preguntar si es la priera vez y estar
            //aumentando el index. ELEGANCIA POR FAVOR!!!
            if ($index === -1) {
                $total = array_values($resultQuery[0])[0];
            } else {

                //Devolver en forma de arreglo de arreglos, no un valor atras del otro pq se pierde la relacion entre cada prom y cada porciento
                //array_push($result, $average[$index]); ESTAS LINEA SE VAN
                $temp = array_values($item);
                $temp = ($temp[0] / $total) * 100;
                //array_push($result, $temp); ESTA LINEA SE VA

                //Para agregar a arreglo se usa $arr[] = $value. Esto añade $value al final del arreglo.
                $result[] = [$average[$index], $temp];
            }

            $index++;
        }



        return $result;
    }

    public function countView($idSale)
    {
        $countView = (new Query())
            ->from('purchase_sale')
            ->where(['sale_id' => $idSale, 'state' => 1])
            ->count();

        return $countView;
    }


    public function countRequested($idSale)
    {
        $countView = (new Query())
            ->from('purchase_sale')
            ->where(['sale_id' => $idSale, 'requested' => 1])
            ->count();

        return $countView;
    }

}
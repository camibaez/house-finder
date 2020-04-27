<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 06/04/2017
 * Time: 1:52
 */

namespace common\models;


class Functions {
    public static $locationsNameRankFunc = "calc_locations_name_rank";
    public static $priceRankFunc = "calc_price_rank";
    public static $relativeRankFunc = "calc_relative_rank";
    public static $termsRankFunc = "calc_term_rank";

    public static function generateFunctionCall($functionName, $params){
        $text = $functionName."(".implode(",", $params).")";
        return $text;
    }

    public static function locationsNameRank($params){
        return static::generateFunctionCall(self::$locationsNameRankFunc, $params);
    }

    public static function priceRank($params){
        return static::generateFunctionCall(self::$priceRankFunc, $params);
    }
    
    public static function priceRankGuide($price, $minPrice, $maxPrice, $pivot, $k){
        
        $i = $minPrice + ($maxPrice - $minPrice) * $pivot;
        $m = (0 - $k) / ($maxPrice - $i);
        $y = $m * abs($price - $i) + $k;
         return $y;       
        
    }

    public static function relativeRank($params){
        return static::generateFunctionCall(self::$relativeRankFunc, $params);
    }
    
    public static function calcTermsRank($terms){
        $functionTerms = [];
        foreach ($terms as $term) {
           $functionTerms[] = self::generateFunctionCall(self::$termsRankFunc, ["'$term'", "title", "description"]);
        }
        
        return "( (" . implode("+", $functionTerms) .") / " . count($terms) . ")";
    }
    
    public static function dateRank($params){
        return static::generateFunctionCall("calc_date_rank", $params);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 18/08/2016
 * Time: 0:57
 */

namespace common\components\access_security;


use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\StringHelper;

class HashAccessSecurity {
    const STRING_DELIMITER = "_";
    public static function checkId($id, $secureId){
        $secretKey = \Yii::$app->params['secretValidationKey'];
        $userId = \Yii::$app->user->id;
        return $secureId == md5($id.$secretKey.$userId);
    }

    public static function generateId($id, $userId = null){
        $secretKey = \Yii::$app->params['secretValidationKey'];
        $userId = $userId? $userId : \Yii::$app->user->id;
        return md5($id.$secretKey.$userId);
    }


} 
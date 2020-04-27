<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 18/08/2016
 * Time: 1:23
 */

namespace common\components\access_security\accessrules;


use common\components\access_security\HashAccessSecurity;
use yii\filters\AccessRule;
use yii\web\ForbiddenHttpException;

class SecureIDRule extends AccessRule{
    public $checkParameters = [
        [
            'idAttr' => 'id',
            'secureAttr' => 'token'
        ],
    ];
    public $allow = false;




    public static function denyCallback(){
        throw new ForbiddenHttpException("No inventes tanto");
    }
    public function matchCallback(){
        foreach ($this->checkParameters as $parameter) {
            $idAttr = \Yii::$app->request->get($parameter['idAttr']);
            $token = \Yii::$app->request->get($parameter['secureAttr']);
            if(!$token)
                throw new ForbiddenHttpException("Error reciviendo el token.");
            if(!HashAccessSecurity::checkId($idAttr, $token))
                return true;
        }
        return false;
    }

    protected function matchCustom($action){
        return $this->matchCallback();
    }




} 
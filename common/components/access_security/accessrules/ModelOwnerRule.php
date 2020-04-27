<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 27/08/2016
 * Time: 0:48
 */

namespace common\components\access_security\accessrules;


use yii\db\Query;
use yii\filters\AccessRule;

class ModelOwnerRule extends AccessRule{
    public $checkParameters = [
        [
            'idAttr' =>'id',
            'ownerAttr' => 'user_username',
        ]
    ];
    public $table;
    public $method = 'get';

    public function matchCallback(){
        foreach ($this->checkParameters as $parameter) {
            $idParam = $parameter['idAttr'];
            $userParam = $parameter['ownerAttr'];

            if($this->method == 'post')
                $id = (int) \Yii::$app->request->post($idParam);
            if($this->method == 'get')
                $id = (int) \Yii::$app->request->get($idParam);
            $user = \Yii::$app->user->id;



            if(!(new Query())->from($this->table)->where([$idParam => $id, $userParam => $user])->exists())
                return true;
        }

        return false;
    }

    protected function matchCustom($action){
        return $this->matchCallback();
    }
} 
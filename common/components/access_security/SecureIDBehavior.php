<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 18/08/2016
 * Time: 1:06
 */

namespace common\components\access_security;


use yii\base\Behavior;

class SecureIDBehavior extends Behavior{
    public function getSecureId(){
       return  HashAccessSecurity::generateId($this->owner->id);
    }

} 
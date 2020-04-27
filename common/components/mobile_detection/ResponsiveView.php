<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 11/07/2017
 * Time: 23:20
 */

namespace common\components\mobile_detection;


use Yii;
use yii\web\View;

class ResponsiveView extends View{
    public function getRespView(){
        return $this->isMobile()? "mobile" : "pc";
    }

    public function isMobile(){
        return Yii::$app->get("mobile-detect")->isMobile();
    }

    public function isPc(){
        return !$this->isMobile();
    }

    public function responsiveRender($view, $params = []){
            return $this->render("{$this->respView}/$view", $params);

    }
} 
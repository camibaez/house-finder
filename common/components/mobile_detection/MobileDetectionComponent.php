<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 09/02/2017
 * Time: 16:50
 */

namespace common\components\mobile_detection;


use Yii;
use yii\base\Component;

class MobileDetectionComponent extends Component{
    const  USER_AGENT_MOBILE = 'mobile';
    const  USER_AGENT_PC = 'pc';
    protected  $_detect;
    protected $userAgentType;

    public function __construct($config = []){
        $this->_detect = new MobileDetect();

        if($this->_detect->isMobile() || $this->_detect->isTablet())
            $this->userAgentType = self::USER_AGENT_MOBILE;
        else
            $this->userAgentType = self::USER_AGENT_PC;

        if(!Yii::$app->user->isGuest)
                Yii::$app->session->set("userAgent", $this->userAgentType);

        parent::__construct($config);
    }

    public function isMobile(){
        return $this->userAgentType == self::USER_AGENT_MOBILE;
    }

    public function getDetect(){
        return $this->_detect;
    }

    public function getUserAgent(){
        return $this->userAgentType;
    }
} 
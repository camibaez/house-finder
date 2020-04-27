<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 19/08/2016
 * Time: 17:30
 */

namespace common\components\access_security\accessrules;


use common\models\Purchase;
use yii\db\Query;
use yii\filters\AccessRule;

class MaxCreationRule extends AccessRule
{
    public $maxCount = 3;
    public $maxTotal = 10;
    public $table;
    public $userColumnName = 'user_username';

    public function matchCallback()
    {
        $maxActiveCount = (new Query())->from($this->table)
                            ->where([$this->userColumnName => \Yii::$app->user->id, 'status' => Purchase::ACTIVE_STATUS])
                            ->count();

        $maxTotalCount = (new Query())->from($this->table)
                        ->where([ $this->userColumnName => \Yii::$app->user->id])
                        ->andWhere(['<>', 'status' , Purchase::ACTIVE_STATUS])
                        ->count();

        return $maxActiveCount >= $this->maxCount || $maxTotalCount >= $this->maxTotal;
    }

    protected function matchCustom($action)
    {
        return $this->matchCallback();
    }

} 
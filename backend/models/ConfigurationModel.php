<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 26/10/2016
 * Time: 0:12
 */

namespace backend\models;


use common\components\matchmaker\MatchmakerDataTable;
use yii\base\Model;
use yii\db\Query;

/**
 * Class ConfigurationModel
 * @package backend\models
 *
 * @property $alive boolean
 * @property $sleepTime integer
 * @property $lastMatchingTime integer
 * @property $daemon_mode boolean
 * @property $done boolean
 */
class ConfigurationModel extends \yii\db\ActiveRecord
{
    
     /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rank_parameters';
    }

    public function rules()
    {

        return [
            [['image', 'price_pivot', 'r_price', 'r_date'], 'number'],
        ];

    }
    
    public function attributeLabels()
    {
        return [
            'image' => 'Images',
        ];
    }
} 
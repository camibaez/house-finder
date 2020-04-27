<?php

namespace backend\models;

use common\models\Purchase;
use common\models\Sale;
use common\models\SaleSearch;
use backend\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "log".
 *
 * @property string $id
 * @property integer $level
 * @property string $category
 * @property double $log_time
 * @property string $prefix
 * @property string $message
 * @property string $ip
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_statistics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level'], 'integer'],
            [['log_time'], 'number'],
            [['prefix', 'message'], 'string'],
            [['ip'], 'required'],
            [['category'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'level' => Yii::t('app', 'Level'),
            'category' => Yii::t('app', 'Category'),
            'log_time' => Yii::t('app', 'Log Time'),
            'prefix' => Yii::t('app', 'Prefix'),
            'message' => Yii::t('app', 'Message'),
            'ip' => Yii::t('app', 'Ip'),
        ];
    }

    /* USERS */
    public function getUsersCount($conditions = null){
        $query = (new Query())->from("user");
        if($conditions)
            $query->where($conditions);
        else
            $query->where(['status' => User::STATUS_ACTIVE]);

        return $query->count();
    }

    public function getAllUsersCount(){
        return self::getUsersCount(['<>', 'status', User::STATUS_ADMIN]);
    }

    public function getIpCount(){
        return $this->find()->select('ip')->distinct()->count();
    }

    /* SELLS */
    public function getActiveSalesCount(){
        return \common\models\House::find()->where(['status' => \common\models\House::SAFE_STATUS])->count();
    }

    public function getAllSalesCount(){
        return \common\models\House::find()->count();
    }

    /* VIEWS */
    public function getViewsCountMap(){
        $query = (new Query())->from(self::tableName())->where(['category' => "statistics\\views"]);
        $totalCount = $query->count();

        $query->select([
            "COUNT(message) AS message_count",
            "COUNT(message) / $totalCount * 100 AS message_percent",
            "message"
        ])->groupBy('message')->orderBy('message_percent DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);



        return $dataProvider;
    }
}

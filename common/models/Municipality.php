<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "municipality".
 *
 * @property integer $id
 * @property string $name
 * @property integer $province_id
 * @property integer $priority
 *
 * @property House[] $houses
 * @property Province $province
 * @property Neighborhood[] $neighborhoods
 */
class Municipality extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'municipality';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id', 'priority'], 'required'],
            [['province_id', 'priority'], 'integer'],
            [['name'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'province_id' => 'Province ID',
            'priority' => 'Priority',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHouses()
    {
        return $this->hasMany(House::className(), ['municipality_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNeighborhoods()
    {
        return $this->hasMany(Neighborhood::className(), ['municipality_id' => 'id']);
    }
}

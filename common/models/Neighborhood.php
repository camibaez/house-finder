<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "neighborhood".
 *
 * @property integer $id
 * @property string $name
 * @property integer $municipality_id
 *
 * @property House[] $houses
 * @property Municipality $municipality
 */
class Neighborhood extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'neighborhood';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'municipality_id'], 'required'],
            [['municipality_id'], 'integer'],
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
            'municipality_id' => 'Municipality ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHouses()
    {
        return $this->hasMany(House::className(), ['neighborhood_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipality()
    {
        return $this->hasOne(Municipality::className(), ['id' => 'municipality_id']);
    }
}

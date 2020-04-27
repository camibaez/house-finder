<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "searches".
 *
 * @property integer $id
 * @property string $value
 * @property integer $price_min
 * @property integer $price_max
 * @property string $terms
 * @property integer $images_only
 * @property string $sites
 * @property integer $created_at
 */
class Searches extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'searches';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_min', 'price_max', 'images_only', 'created_at'], 'integer'],
            [['created_at'], 'required'],
            [['value'], 'string', 'max' => 2048],
            [['terms', 'sites'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'price_min' => 'Price Min',
            'price_max' => 'Price Max',
            'terms' => 'Terms',
            'images_only' => 'Images Only',
            'sites' => 'Sites',
            'created_at' => 'Created At',
        ];
    }
}

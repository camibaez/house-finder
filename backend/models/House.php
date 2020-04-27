<?php

namespace backend\models;

use common\models\Municipality;
use common\models\Neighborhood;
use common\models\Province;
use common\models\SaleThumbImage;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "house".
 *
 * @property string $id
 * @property integer $price
 * @property string $address
 * @property integer $bedroom
 * @property integer $bathroom
 * @property string $area
 * @property integer $province_id
 * @property integer $municipality_id
 * @property integer $neighborhood_id
 * @property integer $zone_id
 * @property integer $house_type_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $description
 * @property double $rank
 * @property string $url
 * @property string $title
 * @property string $site_id
 * @property integer $status
 * @property string $thumb
 * @property integer $reviewed
 *
 * @property FavAds[] $favAds
 * @property User[] $usernames
 * @property Site $site
 * @property Province $province
 * @property Municipality $municipality
 * @property Neighborhood $neighborhood
 * @property Zone $zone
 * @property HouseType $houseType
 * @property SaleImage[] $saleImages
 * @property SaleThumbImage[] $saleThumbImages
 */
class House extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id', 'created_at', 'updated_at', 'url', 'title', 'site_id', 'status', 'reviewed'], 'required'],
            [['price', 'bedroom', 'bathroom', 'area', 'status', 'reviewed'], 'integer'],
            [['zone_id', 'house_type_id', 'province_id', 'municipality_id', 'neighborhood_id', 'thumb'], 'safe'],
            [['area', 'rank'], 'number'],
            [['description', 'url', 'title'], 'string'],
            [['id'], 'string', 'max' => 32],
            [['address'], 'string', 'max' => 1024],
            [['site_id'], 'string', 'max' => 45],
            //[['site_id'], 'exist', 'skipOnError' => true, 'targetClass' => Site::className(), 'targetAttribute' => ['site_id' => 'id']],
            //[['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'id']],
            //[['municipality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Municipality::className(), 'targetAttribute' => ['municipality_id' => 'id']],
            //[['neighborhood_id'], 'exist', 'skipOnError' => true, 'targetClass' => Neighborhood::className(), 'targetAttribute' => ['neighborhood_id' => 'id']],
            //[['zone_id'], 'exist', 'skipOnError' => true, 'targetClass' => Zone::className(), 'targetAttribute' => ['zone_id' => 'id']],
            //[['house_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => HouseType::className(), 'targetAttribute' => ['house_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'address' => 'Address',
            'bedroom' => 'Bedroom',
            'bathroom' => 'Bathroom',
            'area' => 'Area',
            'province_id' => 'Province ID',
            'municipality_id' => 'Municipality ID',
            'neighborhood_id' => 'Neighborhood ID',
            'zone_id' => 'Zone ID',
            'house_type_id' => 'House Type ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'description' => 'Description',
            'rank' => 'Rank',
            'url' => 'Url',
            'title' => 'Title',
            'site_id' => 'Site ID',
            'status' => 'Status',
            'thumb' => 'Thumb',
            'reviewed' => 'Reviewed',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getFavAds()
    {
        return $this->hasMany(FavAds::className(), ['house_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsernames()
    {
        return $this->hasMany(User::className(), ['username' => 'username'])->viaTable('fav_ads', ['house_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Site::className(), ['id' => 'site_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMunicipality()
    {
        return $this->hasOne(Municipality::className(), ['id' => 'municipality_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNeighborhood()
    {
        return $this->hasOne(Neighborhood::className(), ['id' => 'neighborhood_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getZone()
    {
        return $this->hasOne(Zone::className(), ['id' => 'zone_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getHouseType()
    {
        return $this->hasOne(HouseType::className(), ['id' => 'house_type_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSaleImages()
    {
        return $this->hasMany(SaleImage::className(), ['sale_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSaleThumbImages()
    {
        return $this->hasMany(SaleThumbImage::className(), ['sale_id' => 'id']);
    }
}

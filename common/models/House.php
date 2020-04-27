<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "house".
 *
 * @property integer $id
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
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $description
 * @property double $rank
 * @property string $url
 * @property string $title
 * @property string $site_id
 *
 * @property Site $site
 * @property Province $province
 * @property Municipality $municipality
 * @property Neighborhood $neighborhood
 * @property Zone $zone
 * @property HouseType $houseType
 * @property SaleExtraField[] $saleExtraFields
 * @property ExtraField[] $extraFields
 * @property SaleTag[] $saleTags
 * @property Tag[] $tags
 * @property SaleThumbImage[] $saleThumbImages
 */
class House extends \yii\db\ActiveRecord {

    const INACTIVE_STATUS = 0, CRAP_STATE = 1, SAFE_STATUS = 2;


    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'house';
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels() {
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
        ];
    }


    /**
     * Calcula el porciento de resultados devueltos contra el total de resultados disp.
     * @param type $count
     */
    public static function calculateProportion($count){
        $total = House::find()->where(['status' => House::SAFE_STATUS])->count();
        return $count / $total;
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite() {
        return $this->hasOne(Site::className(), ['id' => 'site_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince() {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipality() {
        return $this->hasOne(Municipality::className(), ['id' => 'municipality_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNeighborhood() {
        return $this->hasOne(Neighborhood::className(), ['id' => 'neighborhood_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZone() {
        return $this->hasOne(Zone::className(), ['id' => 'zone_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHouseType() {
        return $this->hasOne(HouseType::className(), ['id' => 'house_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleExtraFields() {
        return $this->hasMany(SaleExtraField::className(), ['sale_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtraFields() {
        return $this->hasMany(ExtraField::className(), ['id' => 'extra_field_id'])->viaTable('sale_extra_field', ['sale_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleTags() {
        return $this->hasMany(SaleTag::className(), ['sale_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags() {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('sale_tag', ['sale_id' => 'id']);
    }

    public function getThumbsLinks() {
        $values = (new \yii\db\Query())->from("sale_thumb_image")->where(['sale_id' => $this->id])->select("url")->indexBy("url")->all();
        return array_keys($values);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleThumbImages() {
        return $this->hasMany(SaleThumbImage::className(), ['sale_id' => 'id']);
    }

    
    public static function saveThumb($id){
        $imageUrl = (new yii\db\Query())->select('url')->from('sale_image')->where(['sale_id' => $id])->scalar();
        if($imageUrl){
            $imageString = null;
            try{
                $imageString = file_get_contents($imageUrl);
                Yii::$app->db->createCommand()->update('house', ['thumb' => $imageString], ['id' => $id])->execute();
            } catch (Exception $ex) {

            } catch (\yii\base\ErrorException $e){
                
            }
            return $imageString;
        }else{
            return false;
        }
    }
    
    public static function getHouseTypeMap(){
        $data = (new \yii\db\Query())->from('house_type')->all();
        return \yii\helpers\ArrayHelper::map($data, 'id', 'name');
    }
    
     public static function getZoneMap(){
        $data = (new \yii\db\Query())->from('zone')->all();
        return \yii\helpers\ArrayHelper::map($data, 'id', 'name');
    }
}

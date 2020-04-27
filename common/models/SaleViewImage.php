<?php

namespace common\models;

use common\assets\ImagesAsset;
use common\components\imageprocessor\ImageProcessor;
use Faker\Provider\Image;
use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "sale_view_image".
 *
 * @property integer $id
 * @property integer $sale_id
 * @property string $extension
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Sale $sale
 */
class SaleViewImage extends \yii\db\ActiveRecord
{
    const IMAGE_EXTENSION = 'jpeg';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sale_view_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sale_id', 'extension'], 'required'],
            [['sale_id',], 'integer'],
            [['extension'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sale_id' => Yii::t('app', 'Sale ID'),
            'extension' => Yii::t('app', 'Extension'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::className(), ['id' => 'sale_id']);
    }




    /**
     * @param $file UploadedFile
     */
    public function saveFile($file){
        //return $file->saveAs(__DIR__."/../assets/images/{$this->id}.{$this->extension}");

        $path = Yii::$app->params['imagesPath'].$this->id.".".self::IMAGE_EXTENSION;
        return ImageProcessor::createJPEG($file->tempName, $path, $file->extension);
    }
    


    public function getImageFile(){
        try{
            return ImagesAsset::publishViewImage($this->id.".".$this->extension)[1];
        }catch (Exception $e){
            return null;
        }

    }

    public function getFilePath(){
        return Yii::$app->params['imagesPath'].$this->id.".".$this->extension;
    }

    public function getSize(){
        $path = $this->filePath;
        $width = $height = 0;
        if(!file_exists($path))
            return null;
        list($width, $height) = getimagesize($path);
        return [$width, $height];
    }
}

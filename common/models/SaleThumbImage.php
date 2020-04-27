<?php

namespace common\models;

use common\assets\ImagesAsset;
use common\components\imageprocessor\ImageProcessor;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "sale_thumb_image".
 *
 * @property integer $id
 * @property integer $sale_id
 * @property resource $data
 * @property string $extension
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Sale $sale
 */
class SaleThumbImage extends \yii\db\ActiveRecord
{
    const THUMB_WIDTH = 300;
    const  THUMB_HEIGHT = 300;
    const IMAGE_EXTENSION = 'jpeg';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sale_thumb_image';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sale_id'], 'integer']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::className(), ['id' => 'sale_id']);
    }

    public function loadImageData($uploadedFile) {
        $file = fopen($uploadedFile->tempName, 'r');
        $fileContent = fread($file, filesize($uploadedFile->tempName));
        $base64 = base64_encode($fileContent);

        $this->data = $base64;
        $this->extension = $uploadedFile->extension;
    }

    public function getEncodedSrcData(){
        $data = $this->data;
        $extension = $this->extension;
        return "data:image/$extension;base64,$data";
    }

    /**
     * @param $file UploadedFile
     */
    public function saveFile($file)
    {
        $newPath = Yii::$app->params['thumbsPath'] . $this->id . "." . self::IMAGE_EXTENSION;
        return ImageProcessor::resizeImage($file->tempName, self::THUMB_WIDTH, self::THUMB_HEIGHT, $newPath, $file->extension);
    }

    public function getImageFile()
    {

        return ImagesAsset::publishThumbnail($this->id . "." . $this->extension)[1];
    }


    public function getFilePath()
    {
        return Yii::$app->params['thumbsPath'] . $this->id . "." . $this->extension;
    }

    public function getSize()
    {
        $path = $this->filePath;
        $width = $height = 0;
        if (!file_exists($path))
            return null;
        list($width, $height) = getimagesize($path);
        return [$width, $height];
    }


}

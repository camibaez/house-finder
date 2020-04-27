<?php
namespace common\assets;

use common\models\Sale;
use Yii;

/**
 * This is class is used to publish the images of the sales.
 *
 */
class ImagesAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '../../images';

    public static function publishThumbnail($name)
    {
        $path = Yii::$app->params['thumbsPath'] . $name;
        return self::publishImage($path);
    }

    /**
     * Publishes an sale image to the assets directory in order to make it accessible
     * @param string $name The name of the image to be published
     * @param array $options An array containing options about how to select the images to publish. \n
     *
     */
    public static function publishImage($path, $options = [])
    {

        try {
            if (file_exists($path)) {
                $response = Yii::$app->assetManager->publish($path);
                return $response;
            }
        } catch (Exception $exc) {

        }


        return null;
    }

    public static function publishViewImage($name)
    {
        $path = Yii::$app->params['imagesPath'] . $name;
        return self::publishImage($path);
    }

    /**
     * @param $sale Sale
     */
    public static function publishSaleImages($sale)
    {
        $imagesNames = [];
        foreach ($sale->images as $image) {
            $result = self::publishImage($image->id . $image->extension);
            if ($result)
                $imagesNames[] = $result;
        }

        return $imagesNames;
    }


}
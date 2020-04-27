<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 06/04/2017
 * Time: 23:42
 */

namespace common\assets;


use yii\web\AssetBundle;

class TagsAssets extends AssetBundle{
    public $js = [
        'tags-events.js',
    ];
    public $sourcePath = '@common/assets/js';
} 
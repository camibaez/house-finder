<?php
if ($model['site_id'] != "Ofertas" && $model['thumb']) {
    $imageString = $model['thumb'];
    $imageString = "data:image/jpeg;base64," . base64_encode($imageString);
    $image = yii\helpers\Html::img($imageString, ['alt' => "House image", 'style' => "text-align: center;width: 100%; height: 100%"]);
} else {

    $imageString = yii\helpers\Url::base() . "/img/nophoto.jpg";
    $image = yii\helpers\Html::img($imageString, ['alt' => "House image", 'style' => "text-align: center;width: 100%; "]);
    
//    if ($imageString = common\models\House::saveThumb($model['id'])) {
//        $imageString = "data:image/jpeg;base64," . base64_encode($imageString);
//        $image = yii\helpers\Html::img($imageString, ['alt' => "House image", 'style' => "text-align: center;width: 100%; height: 100%"]);
//    } else {
//        $imageString = yii\helpers\Url::base() . "/img/nophoto.jpg";
//        $image = yii\helpers\Html::img($imageString, ['alt' => "House image", 'style' => "text-align: center;width: 100%; "]);
//    }
     
}
?>
<span class="price-tag label label-primary ">$<?= Yii::$app->formatter->asDecimal($model['price'], 0); ?></span>

<?php
echo \yii\helpers\Html::button("<span class='glyphicon glyphicon-heart'></span>", [
    'is-fav' => 0,
    'house-id' => $model['id'],
    'class' => "ad-fav-btn btn btn-sm btn-default"
]);
?>


<?php 
	$url = ['house/redirecter', 'url' => $model['url']];


?>

<?= yii\helpers\Html::a($image, $url, ['class' => 'house-image', 'target' => '_blank', 'style' => $this->isMobile() ? 'height: 150px' : ""]); ?>
<?php $titleHeight = $this->isMobile() ? "57px" : "38px" ?>
<?= yii\helpers\Html::a("<h4 class='house-title' style='height: $titleHeight'>{$model['title']}</h4>", $url, ['target' => '_blank']) ?>
<?= yii\helpers\Html::a("en {$model["site_id"]}", $url, ['style' => 'color: gray', 'target' => '_blank']); ?>
<span class="" style="font-size: smaller; <?= $this->isMobile() ? "display:block;" : "display:inline; margin-left: 3px" ?> " > (<?= Yii::$app->formatter->asRelativeTime($model["created_at"]) ?>)</span>
<p class="house-description" style="clear: both"><?= yii\helpers\StringHelper::truncate($model["description"], 1200) ?></p>





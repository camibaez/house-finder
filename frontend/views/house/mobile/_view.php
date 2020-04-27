<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
$links = $model->getThumbsLinks();
$imageString = "";
if ($links) {
    try {
        $imageString = file_get_contents($links[0]);
        $imageString = base64_encode($imageString);
    } catch (Exception $ex) {
        
    }
}
$image = yii\helpers\Html::img("data:image/jpeg;base64," . $imageString, ['alt' => "House image", 'style' => "width: 100%;"]);
?>

<span class="price-tag label label-primary "><?= Yii::$app->formatter->asCurrency($model->price, "CUC"); ?></span>
<?=
$isFav = $model->isFav();
$favBtnClass = $isFav ? "cancel-fav-btn" : "add-fav-btn";
echo \yii\helpers\Html::button("<span class='glyphicon glyphicon-heart'></span>", [
    'is-fav' => $isFav,
    'house-id' => $model->id,
    'class' => "ad-fav-btn $favBtnClass btn btn-sm btn-default"
]);
?>
<?= yii\helpers\Html::a($image, $model->url, ['class' => 'house-image', 'target' => '_blank']); ?>
<?= yii\helpers\Html::a("<h4 class='house-title'>{$model->title}</h4>", $model->url, ['target' => '_blank']) ?>
<?= yii\helpers\Html::a("en {$model->site_id}", $model->url, ['style' => 'color: gray', 'target' => '_blank']); ?>
<p class="house-description"><?= yii\helpers\StringHelper::truncate($model->description, 100) ?></p>





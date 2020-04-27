<?php
if ($model['thumb']) {
    $imageString = $model['thumb'];
    $imageString = "data:image/jpeg;base64," . base64_encode($imageString);
    $image = yii\helpers\Html::img($imageString, ['alt' => "House image", 'style' => "text-align: center;width: 100%; height: 100%"]);
} else {
    if ($imageString = common\models\House::saveThumb($model['id'])) {
        $imageString = "data:image/jpeg;base64," . base64_encode($imageString);
        $image = yii\helpers\Html::img($imageString, ['alt' => "House image", 'style' => "text-align: center;width: 100%; height: 100%"]);
    } else {
        $imageString = yii\helpers\Url::base() . "/img/nophoto.jpg";
        $image = yii\helpers\Html::img($imageString, ['alt' => "House image", 'style' => "text-align: center;width: 100%; "]);
    }
}
$temp = new \common\models\House();
$temp->setAttributes($model, false);
$model = $temp;
?>

<span class="price-tag label label-primary "><?= Yii::$app->formatter->asCurrency($model->price, "CUC"); ?></span>
<?php
echo \yii\helpers\Html::button("<span class='glyphicon glyphicon-remove'></span>", [
    'class' => 'remove-fav-btn btn btn-sm btn-default',
    'house-id' => $model->id,
]);
?>

<?= yii\helpers\Html::a($image, $model->url, ['class' => 'house-image', 'target' => '_blank']); ?>
<?= yii\helpers\Html::a("<h4 class='house-title'>{$model->title}</h4>", $model->url, ['target' => '_blank']) ?>
<?= yii\helpers\Html::a("en {$model->site_id}", $model->url, ['style' => 'color: gray', 'target' => '_blank']); ?>
<p class="house-description"><?= yii\helpers\StringHelper::truncate($model->description, 100) ?></p>





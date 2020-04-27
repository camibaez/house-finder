<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
  $links = $model->getThumbsLinks();
  $imageString = "";
  if ($links) {
  try {
  $imageString = file_get_contents($links[0]);
  $imageString = base64_encode($imageString);
  } catch (Exception $ex) {

  }
  }


  $image = yii\helpers\Html::img("data:image/jpeg;base64," . $imageString, ['alt' => "House image", 'style' => "width: 100%; height: 100%"]);
 */
$image = '';
?>



<span class="price-tag label label-primary ">$<?= Yii::$app->formatter->asDecimal($model->price, 0); ?></span>

<?php
echo \yii\helpers\Html::button("<span class='glyphicon glyphicon-heart'></span>", [
    'is-fav' => 0,
    'house-id' => $model->id,
    'class' => "ad-fav-btn btn btn-sm btn-default"
]);
?>


<?= yii\helpers\Html::a($image, $model->url, ['class' => 'house-image', 'target' => '_blank']); ?>
<?= yii\helpers\Html::a("<h4 class='house-title'>{$model->title}</h4>", $model->url, ['target' => '_blank']) ?>
<?= yii\helpers\Html::a("en {$model->site_id}", $model->url, ['style' => 'color: gray', 'target' => '_blank']); ?>
<p class="house-description"><?= yii\helpers\StringHelper::truncate($model->description, 1200) ?></p>





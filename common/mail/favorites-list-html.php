<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
?>
<div class="new-sales-mail">
    <h1>Lista de favoritos <small><?= Yii::$app->formatter->asDate(time())?></small></h1>
    
    <?= yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}",
        'itemView' => '@common/mail/_favorite_view'
        
    ])?>

</div>


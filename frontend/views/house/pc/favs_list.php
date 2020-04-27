<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\HouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Houses';
?>
<div>

    <?php
    $count = $dataProvider->count;
    if ($count) {
        echo yii\widgets\ListView::widget([
            'itemView' => '_fav_view',
            'itemOptions' => [
                'class' => "ad-list-element col-lg-3 col-md-4"
            ],
            'options' => [
                'id' => 'favs-list',
                'class' => "list-view row"
            ],
            'dataProvider' => $dataProvider,
            'pager' => [
                'maxButtonCount' => 10,
            ],
            'viewParams' => [
                'dataLength' => $count
            ],
            'layout' => "{items}\n<div class='text-center'>{pager}</div>",
        ]);
        echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#save-favs-modal">Salvar lista</button>';
    } else {
        echo $this->render("../_empty_favs_list");
    }
    ?>

</div>




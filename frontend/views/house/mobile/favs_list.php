<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\HouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Houses';
$this->params['searchModel'] = $searchModel;
?>
<div class="house-index">
    <br>

    <?php
    $btnText = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#save-favs-modal">Salvar lista</button>';
    echo yii\widgets\ListView::widget([
        'itemView' => '_fav_view',
        'itemOptions' => [
            'class' => "col-lg-3 col-md-4"
        ],
        'options' => [
            'class' => "list-view row"
        ],
        'dataProvider' => $dataProvider,
        'pager' => [
            'maxButtonCount' => 10,
        ],
        'viewParams' => [
            'dataLength' => $dataProvider->count
        ],
        'layout' => "{items}\n<div class='text-center'>{pager}</div>$btnText",
        'emptyText' => $this->render("../_empty_favs_list"),
    ])
    ?>

</div>


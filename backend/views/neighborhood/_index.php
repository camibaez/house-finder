<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'name',
        'municipality.name:text:Municipio',


        ['class' => 'yii\grid\ActionColumn', 'controller' => 'neighborhood'],
    ],
]); ?>



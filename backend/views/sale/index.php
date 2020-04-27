<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sale', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'price',
            'address',
            'bedroom',
            // 'bathroom',
            // 'area',
            [
                'label' => 'Provincia',
                'value' => function ($data) {
                    return $data->province->name;
                },
            ],
            [
                'label' => 'Municipio',
                'value' => function ($data) {
                    return $data->province->name;
                },
            ],
            // 'neighborhood_id',
            // 'zone_id',
            // 'house_type_id',
            // 'user_username',
            // 'created_at',
            // 'updated_at',
            // 'status',
            // 'description:ntext',
            // 'expiration_status',
            // 'rank',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

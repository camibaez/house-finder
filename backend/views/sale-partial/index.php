<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sale Partials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-partial-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'CREAR VENTA'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Enviar emails'), ['sale-partial/send-emails'], ['class' => 'btn btn-warning']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'price',
            // 'address',
            'bedroom',
            'bathroom',
            // 'area',
            [
                'label' => 'Provincia',
                'value' => function ($data) {
                    if($data->province === null)
                        return '(no definido)';

                    return $data->province->name;
                },
            ],
            [
                'label' => 'Municipio',
                'value' => function ($data) {
                    if($data->municipality === null)
                        return '(no definido)';

                    return $data->municipality->name;
                },
            ],
            // 'neighborhood_id',
            // 'zone_id',
            // 'house_type_id',
            'created_at:date:Creado',
            'updated_at:date:Actual.',
             'status',
            // 'description:ntext',
             'email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

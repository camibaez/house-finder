<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Searches';
$this->params['breadcrumbs'][] = $this->title;

$graphicDatesData = [];
$datesCategories = [];
foreach ($dates as $date) {
    $graphicDatesData[] = (int) $date['d_count'];
    $datesCategories[] = $date['s_date'];
}
?>
<div class="searches-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <div class="row">
        <div class="col-xs-6">
            <div class="ad-graphic">
<?=
miloschuman\highcharts\Highcharts::widget([
    'options' => [
        'title' => ['text' => 'Busquedas'],
        'chart' => ['type' => 'line', 'zoomType' => 'x'],
        'xAxis' => ['title' => ['text' => 'Fecha'], 'categories' => $datesCategories],
        'yAxis' => [
            'title' => ['text' => 'Cantidad'],
        //'type' => 'logarithmic',
        //'minorTickInterval' => 0,
        //'tickInterval' => 0.4
        ],
        'plotOptions' => [
            'line' => [
                'dataLabels' => ['enabled' => false],
            ]
        ],
        'series' => [
            [
                'name' => 'Cantidad',
                'data' => $graphicDatesData,
                'lineColor' => new yii\web\JsExpression("Highcharts.getOptions().colors[1]"),
                'showInLegend' => false,
            ],
        ]
    ]
]);
?>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="ad-graphic">
<?php
$graphicDatesData = [];
$datesCategories = [];
foreach ($datesRaw as $date) {
    $graphicDatesData[] = (int) $date['d_count'];
    $datesCategories[] = $date['s_date'];
}
?>
                <?=
                miloschuman\highcharts\Highcharts::widget([
                    'options' => [
                        'title' => ['text' => 'Busquedas raw'],
                        'chart' => ['type' => 'line', 'zoomType' => 'x'],
                        'xAxis' => ['title' => ['text' => 'Fecha'], 'categories' => $datesCategories],
                        'yAxis' => [
                            'title' => ['text' => 'Cantidad'],
                        //'type' => 'logarithmic',
                        //'minorTickInterval' => 0,
                        //'tickInterval' => 0.4
                        ],
                        'plotOptions' => [
                            'line' => [
                                'dataLabels' => ['enabled' => false],
                            ]
                        ],
                        'series' => [
                            [
                                'name' => 'Cantidad',
                                'data' => $graphicDatesData,
                                'lineColor' => new yii\web\JsExpression("Highcharts.getOptions().colors[1]"),
                                'showInLegend' => false,
                            ],
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>


<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'price_min',
        'price_max',
        'terms',
        'images_only:boolean:Solo imagen',
        'sites',
        'created_at:date:Creado',
        ['class' => 'yii\grid\ActionColumn'],
    ],
]);
?>
</div>

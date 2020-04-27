<?php

use common\models\SaveListForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\captcha\Captcha;
use yii\helpers\Html;

$this->title = 'Estadísticas';
$this->params['searchModel'] = $searchModel;
$this->registerMetaTag([
	'name' => 'description',
	'content' => "Estadísticas sobre los resultados de búsqueda que te permiten analizar datos como los precios o sitios de orígen de los anuncios."
]);


$graphicSitesData = [];
$i = 0;
foreach ($sitesData as $site => $count) {
    $graphicSitesData[] = [
        'name' => $site,
        'y' => (int) $count,
        'color' => new \yii\web\JsExpression("Highcharts.getOptions().colors[$i]"),
    ];
    $i++;
}


$graphicPricesData = [];
$pricesCategories = [];
foreach ($prices as $key => $value) {
    $graphicPricesData[] = (int) $value;
    $pricesCategories[] = $key;
}

$graphicDatesData = [];
$datesCategories = [];
foreach ($dates as $date) {
    $graphicDatesData[] = (int) $date['d_count'];
    $datesCategories[] = $date['s_date'];
}

$params = Yii::$app->request->get();
if ($params)
    $btnUrl = ['house/search'] + $params;
else
    $btnUrl = ['site/index'];
?>
<div class="favs-index">
    <h1 id="favorites-header" > Estadísticas <span class="pull-right   btn-default btn-sm" style=" line-height: 2.8"><?= Html::a("Volver a resultados", $btnUrl) ?></span></h1>
    <hr>

    <h4>Total: <?= $total ?> resultados </h4>
    <div class="row">
        <div class="col-md-6 ">
            <div class="ad-graphic">
                <?=
                miloschuman\highcharts\Highcharts::widget([
                    'options' => [
                        'title' => ['text' => 'Sitios de origen'],
                        'series' => [
                            [
                                'type' => 'pie',
                                'name' => 'Cantidad',
                                'data' => $graphicSitesData,
                                //'center' => [100, 80],
                                //'size' => 100,
                                'showInLegend' => true,
                                'dataLabels' => [
                                    'enabled' => true,
                                    'format' => (!$this->isMobile() ? '<b>{point.name}</b>:' : "") . '{point.percentage:.1f} %'
                                ],
                            ],
                        ]
                    ]
                ]);
                ?>
            </div>

        </div>
        <div class="col-md-6">
            <div class="ad-graphic">
                <?=
                miloschuman\highcharts\Highcharts::widget([
                    'options' => [
                        'title' => ['text' => 'Precios'],
                        'chart' => ['type' => 'area', 'zoomType' => 'x'],
                        'xAxis' => ['title' => ['text' => 'Precio (miles CUC)'], 'categories' => $pricesCategories],
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
                                'data' => $graphicPricesData,
                                'lineColor' => new yii\web\JsExpression("Highcharts.getOptions().colors[1]"),
                                'showInLegend' => false,
                            ],
                        ]
                    ]
                ]);
                ?>
            </div>

        </div>

        <div class="col-md-6">
            <div class="ad-graphic">
                <?=
                miloschuman\highcharts\Highcharts::widget([
                    'options' => [
                        'title' => ['text' => 'Fechas'],
                        'chart' => ['type' => 'column', 'zoomType' => 'x'],
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


</div>
<style>
    .ad-graphic{
        background-color: white;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.1); 
        margin-bottom: 15px;
    }

</style>
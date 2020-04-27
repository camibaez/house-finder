<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\HouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resultados';
$this->params['searchModel'] = $searchModel;
$this->registerMetaTag([
	'name' => 'description',
	'content' => "Listado de resultados de la búsqueda de anuncios."
]);
?>
<div class="house-index">


    <?php
    $count = $dataProvider->totalCount;


    $proportion = ceil(common\models\House::calculateProportion($count) * 100);
    if ($count < 20) {
       
        yii\bootstrap\Alert::begin([
            'options' => [
                'class' => 'alert-warning'
            ]
        ]);
        echo "Menos del $proportion% de los anuncios coinciden con tus parámetros de búsqueda.";
        yii\bootstrap\Alert::end();
    }
    ?>

    <p style="margin-top: 10px;">
        <span style="color: gray">
            <?php $text = $this->isMobile()? "<b>$proportion%</b> de coincidencia"  : 
                                             "Se encontraron <b>$count</b> resultados (<b>$proportion%</b> de coincidencia)"?>
            <?= $text; ?>
        </span>
        <span id="fake-order-button" style="float: right">
             <?=

                 Html::dropDownList('fake-order', $searchModel->order, [
                \common\models\HouseSearch::$MAGIC_ORDER => 'Ordernar por magia',
                \common\models\HouseSearch::$DATE_ORDER => 'Ordenar por fecha',
                     \common\models\HouseSearch::$HIGH_PRICE_ORDER => 'Ordenar precio desc',
                \common\models\HouseSearch::$LOW_PRICE_ORDER => 'Ordenar precio asc',
                     
            ],['style' => ' border-color: transparent; color: gray; float: right', 'onchange' => '$("#order-button>input").val($(this).val()); $("#search-form").submit()'])
            ?>
        </span>
       
    </p>
    <?=
    yii\widgets\ListView::widget([
        'itemView' => '_view',
        'itemOptions' => [
            'class' => "ad-list-element col-lg-3 col-md-4 col-xs-6"
        ],
        'options' => [
            'class' => "list-view row"
        ],
        'dataProvider' => $dataProvider,
        'pager' => [
            'maxButtonCount' => $this->isMobile() ? 7 : 10,
        ],
        'viewParams' => [
            'dataLength' => $dataProvider->count
        ],
        'layout' => "{items}<div class='text-center' style='clear: both'>{summary}\n{pager}</div>",
        'emptyText' => $this->render("_empty_house_list"),
    ])
    ?>

</div>

<style>
    #fake-order-button>select{
        cursor: pointer;

    }
    #fake-order-button option{

       
    }
</style>
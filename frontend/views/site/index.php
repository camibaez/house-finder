<?php


/* @var $this yii\web\View */
$this->title = 'Venderor - Búsqueda de casas en venta en Cuba';
?>

<div class="site-index" style="margin-top: calc(50vh - 260px)">
    <div style="text-align: center">
        <?= yii\helpers\Html::img(yii\helpers\Url::base()."/img/logo_tiny.svg", ['style' => 'width: ' . ($this->isMobile()? "70vw" : "390px")]) ?>
    </div>


    <div id="homeQuickSearch" class="row " style="text-align: left">
        <div style="padding-left: 15px; padding-right:15px">
            <div class="col-xs-12  col-md-6 col-md-offset-3" style="padding-left: 0; padding-right: 0"> 
                <?= $this->render('@frontend/views/house/_quick_search_form'); ?>
            </div>
        </div>
    </div>
    <p style="font-size: 16px; text-align: center; margin-top: 12px; color: rgb(154, 154, 154);">
        El primer motor de búsquedas de casas en venta de Cuba. 
        <?= \yii\helpers\Html::a("Saber más.", ['site/about'])?>
    </p>
</div>

<style>
    .quick-search-content > div {
        padding-top: 10px;
    }




</style>
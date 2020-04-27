<?php
/* @var $this yii\web\View */
?>

<div class="site-index" style="margin-top: 10%">
    <div style="text-align: center">
        <h1 style="text-align: center; font-size: 60px"><img style="width:  85px" src="https://gracemusic.us/wp-content/uploads/2016/05/search-icon.png"></span> Finder</h1>
    </div>
    <br>

    <div id="homeQuickSearch" class="row " style="text-align: left">
        <div style="padding-left: 15px; padding-right:15px">
            <div class="col-xs-12  col-md-6 col-md-offset-3" style="padding-left: 0; padding-right: 0"> 
                <?= $this->render('@frontend/views/house/_quick_search_form'); ?>
            </div>
        </div>
    </div>
    <p style="font-size: 16px; text-align: center; margin-top: 12px; color: rgb(154, 154, 154);">
        El primer motor de busquedas de casas en venta. 
        <?= \yii\helpers\Html::a("Saber más.", ['site/contact'])?>
    </p>
</div>

<style>
    .quick-search-content > div {
        padding-top: 10px;
    }
    .footer{
        position: fixed;
        bottom: 0;
        width: 100%;

    }



</style>
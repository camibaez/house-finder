<?php
/* @var $this yii\web\View */
?>
<div class="site-index" >
    <h1 style="text-align: center; font-size: 60px">Finder</h1><br>
    <div id="homeQuickSearch" class="row " style="text-align: left">
        <div style="padding-left: 15px; padding-right:15px">
            <div class="col-xs-12  col-md-8 col-md-offset-2 light-wrapper" style="padding-left: 0; padding-right: 0"> 
                <?= $this->render('@frontend/views/house/_quick_search_form') ?>
            </div>
        </div>
    </div>

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
    body>.wrap{
        margin-top: 5%;
    }

</style>
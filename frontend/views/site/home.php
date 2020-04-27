<?php
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index" >

    <?=
    \yii\bootstrap\Carousel::widget([
        'items' => [
            "<img src='http://localhost/virtualstore/frontend/web/img/Afrokat-Multi.jpeg' style='height: 300px; width: 100%'>",
            "<img src='http://localhost/virtualstore/frontend/web/img/Afrokat-Red.png' style='height: 300px; width: 100%'>",
            "<img src='http://localhost/virtualstore/frontend/web/img/Bolt-App-Wallpaper_5.jpg' style='height: 300px; width: 100%'>",
        ],
            //'options' => ['style' => 'height: 300px'],
    ])
    ?>
    <div class="row">

        <div class="col-lg-9">

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-10">
            <div class="row categories-panel">
                <div class="col-lg-12"><h3 style="margin-top: 0px; text-align: center; border-bottom: #777 solid 1px; padding-bottom: 5px">Welcome Robert, look what we've got today.</h3></div>
                <div class="col-lg-3">
                    <a href="category-index"><img src='http://localhost/virtualstore/frontend/web/img/cabin.png' style='height: auto; width: 100%'></a>
                    <h4>Vehicles</h4>
                </div>
                <div class="col-lg-3">
                    <a href="#"><img src='http://localhost/virtualstore/frontend/web/img/circus.png' style='height: auto; width: 100%'></a>
                    <h4>Category</h4>
                </div>
                <div class="col-lg-3">
                    <a href="#"><img src='http://localhost/virtualstore/frontend/web/img/game.png' style='height: auto; width: 100%'></a>
                    <h4>Category</h4>
                </div>
                <div class="col-lg-3">
                    <a href="#"><img src='http://localhost/virtualstore/frontend/web/img/cake.png' style='height: auto; width: 100%'></a>
                    <h4>Category</h4>
                </div>
                <div class="col-lg-3">
                    <a href="#"><img src='http://localhost/virtualstore/frontend/web/img/cabin.png' style='height: auto; width: 100%'></a>
                    <h4>Category</h4>
                </div>
                <div class="col-lg-3">
                    <a href="#"><img src='http://localhost/virtualstore/frontend/web/img/circus.png' style='height: auto; width: 100%'></a>
                    <h4>Category</h4>
                </div>
                <div class="col-lg-3">
                    <a href="#"><img src='http://localhost/virtualstore/frontend/web/img/game.png' style='height: auto; width: 100%'></a>
                    <h4>Category</h4>
                </div>
                <div class="col-lg-3">
                    <a href="#"><img src='http://localhost/virtualstore/frontend/web/img/cake.png' style='height: auto; width: 100%'></a>
                    <h4>Category</h4>
                </div>
            </div>
        </div>

        <div class="col-lg-2 light-wrapper">

            <h4 style="text-align: center; border-bottom: #777 solid 1px; padding-bottom: 5px">Sponsored Products</h4>
            <div class="row sponsored-aside " >
                <div class="col-xs-12"> 
                    <a href="#">
                        <img src='http://localhost/virtualstore/frontend/web/img/Afrokat-Multi.jpeg' style='height: 100px; width: 100%'>
                        <p>A good product</p>
                        <p style="font-size:16px; font-weight: bold">$100</p>

                    </a>
                </div>

                <div class="col-xs-12"> 
                    <a href="#">
                        <img src='http://localhost/virtualstore/frontend/web/img/Afrokat-Red.png' style='height: 100px; width: 100%'>
                        <p>A good product</p>
                        <p style="font-size:16px; font-weight: bold">$100</p>

                    </a>
                </div>

                <div class="col-xs-12"> 
                    <a href="#">
                        <img src='http://localhost/virtualstore/frontend/web/img/Bolt-App-Wallpaper_5.jpg' style='height: 100px; width: 100%'>
                        <p>A good product</p>
                        <p style="font-size:16px; font-weight: bold">$100</p>
                    </a>
                </div>

                <div class="col-xs-12"> 
                    <a href="#">
                        <img src='http://localhost/virtualstore/frontend/web/img/Afrokat-Red.png' style='height: 100px; width: 100%'>
                        <p>A good product</p>
                        <p style="font-size:16px; font-weight: bold">$100</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .categories-panel h4{
        text-align: center;
    }
    .categories-panel img{
        border-radius: 4px;
    }
    .categories-panel img:hover{
        opacity: 0.7;
    }
</style>
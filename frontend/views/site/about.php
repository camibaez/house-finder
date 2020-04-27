<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Acerca de Venderor';

$this->registerMetaTag([
	'name' => 'description',
	'content' => "El objetivo de Venderor es encontrar anuncios de ventas de casas que te puedan interesar recolectándolos desde los sitios que se usan para esto. "
]);
?>
<div class="site-about row" style="text-align: center" >
    <div class="col-md-6 col-md-offset-3">
        <h1 style="text-align: center; " class="hidden-xs">Acerca de Venderor</h1>
        <h2 class="visible-xs" style="margin-bottom: 0">Acerca de Venderorsd</h2>
        <hr class="hidden-xs">
        <br class="hidden-md hidden-lg">
        <p style="font-size: 16px; line-height: 22px;">
            El objetivo de <b>Venderor</b> es simple: encontrar <b>anuncios de ventas de 
            casas</b> que te puedan interesar revisando los sitios que se usan para esto. 
            <br>
            <b>Venderor</b> recolecta anuncios de diferentes sitios como <?= Html::a("revolico.com", "http://revolico.com")?> o 
            <?= Html::a("cubisima.com", "http://cubisima.com")?>, y te muestra los resultados que se ajusten a tus términos de búsqueda. 
            Los resultados son enlaces directos a los sitios donde se encuentran los anuncios.
            <br> <br>
            Por ahora la información se obtiene de estos sitios:
        <div class="row" style="font-size: 16px; text-align: left">
            <div class="col-md-4 col-xs-6"><?= Html::a("revolico.com", "http://revolico.com")?></div>
            <div class="col-md-4 col-xs-6"><?= Html::a("cubisima.com", "http://cubisima.com")?></div>
            <div class="col-md-4 col-xs-6"><?= Html::a("detrasdelafachada.com", "http://detrasdelafachada.com")?></div>
            <div class="col-md-4 col-xs-6"><?= Html::a("ofertas.cu", "http://ofertas.cu")?></div>
        </div>
        </p>
        <br>

        <?= Html::a("<span class='glyphicon glyphicon-search'></span> Quiero buscar una casa", ['site/index'], ['class' => 'btn btn-primary'])?>
        <br><hr>
        <p style="">
            Este proyecto acaba de comenzar. Sería de gran ayuda que nos dieras 
            tu opinión y compartieras tus experiencias acerca del sitio. 
            Es la mejor forma de poder mejorarlo y hacer que cada vez los resultados 
            sean mejores. ¡El equipo de Venderor te lo agredece! 
            
        </p>
        <?= Html::a("Dejar comentario", ['site/contact'], ['class' => 'btn btn-default'])?>
    </div>
    

</div>
<br>

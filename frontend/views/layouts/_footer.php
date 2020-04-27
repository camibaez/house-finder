<?php
$params = Yii::$app->request->get();

$btnUrl = ['house/graphics'] + $params;
?>
<br class="visible-xs">
<footer class="footer">
    <div class="container" style="text-align: center">
        <p style="margin-bottom: 5px">
        <?= \yii\helpers\Html::a("Saber más", ['site/about'] + $params) ?> | 
        <?= \yii\helpers\Html::a("Comentar", ['site/contact'] + $params) ?> |
        <?= \yii\helpers\Html::a("Estadísticas", ['house/graphics'] + $params) ?>
        </p>
		<p><a href="https://www.facebook.com/venderor.site/">Facebook</a></p>
        <p>&copy; Venderor <?= date('Y') ?></p>

    </div>
</footer>
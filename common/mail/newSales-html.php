<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */


$resetLink = "http://7dcasas.com/index.php/site/home";

$resetLink = $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/home']);
?>
<div class="new-sales-mail">
    <p>Hola <?= Html::encode($user->first_name) ?>, hay <b> <?= $count ?> <?= $count > 1 ? "nuevas ventas </br> que te pueden" : "nueva venta </br> que te puede" ?> interesar.</p>

    <p>Sigue <?= Html::a("este link", $resetLink, ['class' => 'btn btn-success']) ?> y visita tu cuenta para que puedas ver más detalles. </p>

    <p>Saludos del equipo de Sevende.</p>
</div>


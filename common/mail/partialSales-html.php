<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\SalePartial */


//$resetLink = "//sevende.com/index.php/sale/create?partial=";
//Yii::$app->urlManager->setHostInfo("https://localhost/house/frontend/web");
$resetLink = "http://7dcasas.com". Yii::$app->urlManager->createUrl(['sale-partial/create', 'partialId' => $model->id, 'email' => $model->email]);
?>
<div class="new-sales-mail">
    <p>¡Hola, futuro cliente!</p>

    <p>
        ¿Recuerdas aquella venta que registraste en <?= $model->web ?>?
        Pues te invitamos a que también la registres en <?= Html::a("Sevende", "http://7dcasas.com") ?>, así tu venta tendrá
        más alcance.
    </p>

    <p>No tendrás que escribir todos los datos otra vez, nosotros ya lo hemos hecho por ti. Solamente necesitamos que
        completes la información que falta y nos des tu aprobación</p>

    <p>Sigue el siguiente link y únete a nosotros.</p>
    <?= Html::a("Registrarme en Sevende", $resetLink, ['class' => 'btn btn-success']) ?>

    <p>Saludos del equipo de Sevende</p>
</div>


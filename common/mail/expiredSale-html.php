<?php
use common\components\access_security\HashAccessSecurity;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $model \common\models\Sale */


$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['sale/reactivate-sale', 'id' => $model->id, 'token' => HashAccessSecurity::generateId($model->id, $user->username)]);
?>
<div class="new-sales-mail">
    <p>Hola <?= Html::encode($user->first_name) ?>.</p>

    <?php
    if($count == -1)
        echo '<p>Lo sentimos, tu venta ha estado más de 90 días inactiva y ha expirado.</p>';
    else
        echo "<p>Dentro de $count ".($count > 1 ? "días" : "día") . " expirará el tiempo de vida de tu venta.</p>";
    ?>


    <p>Si deseas reactivarla por 90 días más por favor sigue este link</p>

    <p><?= Html::a($resetLink, $resetLink, ['class' => 'btn btn-success']) ?></p>

    <p>Saludos del equipo de Sevende</p>
</div>

<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $loginForm \frontend\models\LoginForm */
/* @var $model \frontend\models\UserValidation */

use yii\helpers\Html;

$this->title = Yii::$app->name . " | " . Yii::t("app", 'Registro');

?>
<div class="site-signup col-lg-4 col-lg-offset-4 light-wrapper" >
    <h1 style="text-align:center">Signup</h1>
    
    <br>
    <div class="row">
        <div class="col-xs-12">
           <?= $this->render("_signup_form", ['model' => $model]);?>

            <div style="text-align: center; padding-top: 20px">¿Tienes una cuenta? <?= Html::a("Inicia sesión", ['site/login'])?></div>
            <br>
        </div>
    </div>
</div>

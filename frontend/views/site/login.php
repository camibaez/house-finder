<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::$app->name . " | " . Yii::t("app", 'Login');
?>
<div class="site-signup col-lg-4 col-lg-offset-4 light-wrapper" >
    <h1 style="text-align:center">Login</h1>
    
    <br>
    <div class="row">
        <div class="col-xs-12">
           <?= $this->render("_login_form", ['model' => $model]);?>

            <div style="text-align: center; padding-top: 20px">¿Eres nuevo? <?= Html::a("Regístrate", ['site/signup'])?></div>
            <br>
        </div>
    </div>
</div>

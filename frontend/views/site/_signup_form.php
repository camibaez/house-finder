<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $userModel UserValidation */

use common\models\Countries;
use common\models\User;
use frontend\models\UserValidation;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use kartik\password\PasswordInput;

?>
<div class="house-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->input(['type' => 'email']) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

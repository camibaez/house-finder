<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Searches */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="searches-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_min')->textInput() ?>

    <?= $form->field($model, 'price_max')->textInput() ?>

    <?= $form->field($model, 'terms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'images_only')->textInput() ?>

    <?= $form->field($model, 'sites')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Purchase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'price_min')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_max')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bedroom_min')->textInput() ?>

    <?= $form->field($model, 'bathroom_min')->textInput() ?>

    <?= $form->field($model, 'area_min')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_max')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

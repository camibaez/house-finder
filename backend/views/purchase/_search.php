<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'price_min') ?>

    <?= $form->field($model, 'price_desired') ?>

    <?= $form->field($model, 'price_max') ?>

    <?= $form->field($model, 'bedroom_min') ?>

    <?php // echo $form->field($model, 'bathroom_min') ?>

    <?php // echo $form->field($model, 'area_min') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'area_max') ?>

    <?php // echo $form->field($model, 'user_username') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Neighborhood */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="neighborhood-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autofocus' => '']) ?>

    <?= $form->field($model, 'municipality_id')->dropdownList(
    \common\models\Municipality::find()->select(['name', 'id'])->indexBy('id')->column(),
    ['prompt'=>'Select Municipality']
    ); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

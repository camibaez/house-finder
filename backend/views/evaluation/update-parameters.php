<?php
/* @var $this View */
/* @var $form ActiveForm */
/* @var $model \frontend\models\LoginForm */

use kartik\slider\Slider;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Evaluation parameters';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

    <?php $sep = '<span style="margin-right:50px">&nbsp;</span>'; ?>
    <div class="row">
        <div class="col-lg-3">
            <?=
            $form->field($model, 'image')->widget(Slider::class, [
                'sliderColor' => Slider::TYPE_PRIMARY,
                'handleColor' => Slider::TYPE_PRIMARY,
                'pluginOptions' => [
                    'precision' => 2,
                    'orientation' => 'vertical',
                    'handle' => 'square',
                    'step' => 0.1,
                    'tooltip' => 'always',
                    'reversed' => true,
                    'max' => 2
                ],
            ])
            ?>
        </div>
        <div class="col-lg-3">
            <?=
            $form->field($model, 'price_pivot')->widget(Slider::class, [
                'sliderColor' => Slider::TYPE_PRIMARY,
                'handleColor' => Slider::TYPE_PRIMARY,
                'pluginOptions' => [
                    'precision' => 2,
                    'orientation' => 'vertical',
                    'handle' => 'square',
                    'step' => 0.1,
                    'tooltip' => 'always',
                    'reversed' => true,
                    'max' => 1
                ],
            ])
            ?>
        </div>
        <div class="col-lg-3">
            <?=
            $form->field($model, 'r_price')->widget(Slider::class, [
                'sliderColor' => Slider::TYPE_PRIMARY,
                'handleColor' => Slider::TYPE_PRIMARY,
                'pluginOptions' => [
                    'precision' => 2,
                    'orientation' => 'vertical',
                    'handle' => 'square',
                    'step' => 0.1,
                    'tooltip' => 'always',
                    'reversed' => true,
                    'max' => 1
                ],
            ])
            ?>
        </div>
         <div class="col-lg-3">
            <?=
            $form->field($model, 'r_date')->widget(Slider::class, [
                'sliderColor' => Slider::TYPE_PRIMARY,
                'handleColor' => Slider::TYPE_PRIMARY,
                'pluginOptions' => [
                    'precision' => 2,
                    'orientation' => 'vertical',
                    'handle' => 'square',
                    'step' => 0.1,
                    'tooltip' => 'always',
                    'reversed' => true,
                    'max' => 1
                ],
            ])
            ?>
        </div>

    </div>



    <br>
    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?= Html::a('Run evaluation', ['evaluation/run-evaluation'], ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>

</div>

<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contactar';

$this->registerMetaTag([
	'name' => 'description',
	'content' => "Envía tus comentarios y ayudanos a mejorar tu experiencia y la de otros usuarios en Venderor."
]);
?>
<div class="site-contact row" style="text-align: center">
    <div class="col-md-6 col-md-offset-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <hr>
        <p>
            Envíanos tu comentario, ayudanos a hacer crecer este proyecto.
        </p>

        <div class="row" style="text-align: left">

            <div class="col-md-8 col-md-offset-2">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

                <?=
                $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-6">{image}</div><div class="col-lg-6">{input}</div></div>',
                ])
                ?>

                <div class="form-group">
                    <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>


</div>

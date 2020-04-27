<?php

use common\models\SaveListForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\captcha\Captcha;
use yii\helpers\Html;

$this->title = 'Favoritos';
$this->registerMetaTag([
	'name' => 'description',
	'content' => "Listado de favoritos donde guardar los anuncios que más te interesan."
]);
?>
<div class="favs-index">
    <h1 id="favorites-header" style=""> Favoritos

    </h1>

    <?php if($dataProvider->count > 0){ ?>
    <span id="favs-list-options" class="pull-right" style="display: block; margin-top: -47px; text-align: right">
        <?= Html::button("Limpiar lista", ['class' => 'btn btn-default btn-sm', 'onclick' => 'setCookiesFavIds([]); document.location.reload()'])?>
    </span>
    <?php } ?>
    <hr style="margin-top: 10px">

    <div id="favs-content">
        <?php
        echo yii\widgets\ListView::widget([
            'itemView' => '_fav_view',
            'itemOptions' => [
                'class' => "ad-list-element col-lg-3 col-md-4"
            ],
            'options' => [
                'id' => 'favs-list',
                'class' => "list-view row"
            ],
            'dataProvider' => $dataProvider,
            'pager' => [
                'maxButtonCount' => 10,
            ],
            'layout' => "{items}\n<div class='text-center'>{pager}</div>",
            'emptyText' => $this->render("_empty_favs_list")
        ]);
        ?>



    </div>
    <?php
    if ($dataProvider->count > 0) {

        $form = ActiveForm::begin([
                    'action' => 'save-favs',
                    'id' => 'save-favs-form'
        ]);

        Modal::begin([
            'toggleButton' => ['label' => 'Salvar lista', 'style' => "margin-top: 5px",  'class' => 'btn btn-primary ' . ($this->isMobile()? 'btn-block ' : '')],
            'header' => '<h3 style="margin:0">Salva tu lista</h3>',
            'footer' => Html::submitButton("Salvar", ['id' => 'submit-favs-btn', 'class' => 'btn btn-success']) . Html::button("Cancelar", ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
            'id' => 'save-favs-modal',
            'size' => 'modal-sm',
        ]);
        ?>
        <p>Salva tu lista de favoritos y envíala a tu correo.</p>
        <div class='form-group'>
            <?php $model = new SaveListForm(); ?>
            

            <?= $form->field($model, 'email')->input('email', ['placeholder' => 'Escribe tu email aquí']); ?>
            <?=
            $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-6">{image}</div><div class="col-lg-6">{input}</div></div>',
            ])
            ?>
        </div>
        <?php
        Modal::end();
        ActiveForm::end();
    }
    ?>
</div>

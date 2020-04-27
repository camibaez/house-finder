<?php

use common\components\mobile_detection\MobileDetectionComponent;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php
if (!isset($resultsView))
    $resultsView = false;
if (!isset($model))
    $model = new common\models\HouseSearch ();
$isGraphics = Yii::$app->request->pathInfo == 'house/graphics';

$form = ActiveForm::begin([
            'id' => 'search-form',
            'action' => [!$isGraphics ? 'house/search' : 'house/graphics'],
            'method' => 'get',
            'fieldConfig' => [
                'template' => '{input}'
            ]
        ]);
?>
<div  class="quick-search-content">
    <div class="" style="float: left; width: calc(100% - 52px)">

        <?=
        $form->field($model, 'terms')->widget(kartik\typeahead\Typeahead::class, [
            'options' => [
                'placeholder' => '¿Dónde quieres tu casa?' . ($this->isMobile() ? "" : ' Prueba "Playa, La Habana"'),
                'class' => 'input-lg',
                'style' => 'border-top-right-radius: 0; border-bottom-right-radius: 0;',
            ],
            'pluginOptions' => ['highlight' => true,],
            'dataset' => [
                [
                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                    'display' => 'value',
                    //'prefetch' => $baseUrl . '/samples/countries.json',
                    'remote' => [
                        'url' => yii\helpers\Url::to(['house/locations-list']) . '?q=%QUERY',
                        'wildcard' => '%QUERY'
                    ],
                ]
            ],
        ])
        ?>
    </div>
    <div style="padding-left: 0; display: inline-block">
        <div class="form-group" style="">
            <?=
            Html::submitButton('<span class="glyphicon glyphicon-search"></span>', [
                'class' => 'btn btn-lg btn-primary btn-block',
                'style' => 'border-top-left-radius: 0; border-bottom-left-radius: 0;' . ($this->isMobile() ? 'padding-bottom: 9px' : '')
            ])
            ?>
        </div>
    </div>

    <?php if (isset($resultsView) && $resultsView) { ?>
        <div class="row">
            <div class="col-xs-12">
                <?= $this->render('_filters', ['form' => $form, 'model' => $model]) ?>
            </div> 
        </div>    

    <?php } ?>


    <?php if (isset($resultsView) && $resultsView) { ?>
    <span id="order-button"><?= Html::activeHiddenInput($model, 'order'); ?></span>
    <?php } ?>

</div>
<?php ActiveForm::end(); ?>
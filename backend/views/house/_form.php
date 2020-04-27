<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\House */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="house-form">

    <?php $form = ActiveForm::begin([
        'action' => ['house/review', 'id' => $model->id]
    ]); ?>

    <div class="row">
        <div class="col-xs-12"><?= $form->field($model, 'price')->textInput() ?></div>
        <div class="col-xs-4"><?= $form->field($model, 'bedroom')->textInput() ?></div>
        <div class="col-xs-4"><?= $form->field($model, 'bathroom')->textInput() ?></div>
        <div class="col-xs-4"> <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?></div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-md-4">
            <?=
            $form->field($model, 'province_id')->widget(kartik\typeahead\Typeahead::class, [
                'pluginOptions' => ['highlight' => true,],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        'remote' => [
                            'url' => yii\helpers\Url::to(['house/locations']) . '?q=%QUERY&l=1',
                            'wildcard' => '%QUERY'
                        ],
                    ]
                ],
            ])
            ?>
            <span><?= $model->province_id? $model->province->name : ""?></span>
        </div>
        <div class="col-xs-6 col-md-4"> <?=
            $form->field($model, 'municipality_id')->widget(kartik\typeahead\Typeahead::class, [
                'pluginOptions' => ['highlight' => true,],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        'remote' => [
                            'url' => yii\helpers\Url::to(['house/locations']) . '?q=%QUERY&l=2',
                            'wildcard' => '%QUERY'
                        ],
                    ]
                ],
            ])
            ?>
             <span><?= $model->municipality_id? $model->municipality->name : ""?></span>
        </div>
        <div class="col-xs-6 col-md-4"> <?=
            $form->field($model, 'neighborhood_id')->widget(kartik\typeahead\Typeahead::class, [
                'pluginOptions' => ['highlight' => true,],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        'remote' => [
                            'url' => yii\helpers\Url::to(['house/locations']) . '?q=%QUERY&l=3',
                            'wildcard' => '%QUERY'
                        ],
                    ]
                ],
            ])
            ?>
             <span><?= $model->neighborhood_id? $model->neighborhood->name : ""?></span>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 col-md-4"> <?= $form->field($model, 'zone_id')->dropDownList(common\models\House::getZoneMap()) ?></div>
        <div class="col-xs-6 col-md-4"> <?= $form->field($model, 'house_type_id')->dropDownList(common\models\House::getHouseTypeMap()) ?></div>
        <div class="col-xs-6 col-md-4"><?= $form->field($model, 'status')->dropDownList([0 => 'Inactivo', 1 => 'Incompleto', 2 => 'Seguro']) ?></div>
    </div>

    <?php
    

    ?>








    <div class="form-group">
        <br>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

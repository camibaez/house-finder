<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SalePartial */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="sale-partial-form">

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'web')->textInput(['maxlength' => true]) ?>


        <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'house_type_id')->dropDownList(\common\models\HouseType::houseTypesMap(), ['prompt' => "Selecciona tipo de casa"]) ?>
            </div>
            <div class="col-xs-12 col-lg-4">
                <?= $form->field($model, 'price')->input('number', ['maxlength' => true, 'placeholder' => 'Precio']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div
                    id="cmbProvince"><?= $form->field($model, 'province_id')->dropDownList(\common\models\Province::provincesMap(), ['prompt' => 'Selecciona la provincia...']) ?></div>
            </div>
            <div class="col-sm-4">
                <?php $municipalities = $model->isNewRecord ? [] : \common\models\Municipality::municipalitiesMap($model->province_id) ?>
                <div
                    id="cmbMunicipality"><?= $form->field($model, 'municipality_id')->dropDownList($municipalities, ['prompt' => "Selecciona el municipio..."]) ?></div>
            </div>

            <div class="col-sm-4">
                <?php $neighborhoods = $model->isNewRecord ? [] : \common\models\Neighborhood::neighborhoodsMap($model->municipality_id) ?>
                <div
                    id="cmbNeighborhood"><?= $form->field($model, 'neighborhood_id')->dropDownList($neighborhoods, ['prompt' => "Selecciona el barrio..."]) ?></div>
            </div>
        </div>


        <div class="row">
            <div
                class="col-xs-12"><?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => "Dirección (Opcional)"]) ?></div>
        </div>


        <hr>
        <div class="row">
            <div
                class="col-xs-6 col-md-4"><?= $form->field($model, 'bedroom')->input('number', ['placeholder' => 'Cuartos']) ?></div>
            <div
                class="col-xs-6 col-md-4"><?= $form->field($model, 'bathroom')->input('number', ['placeholder' => 'Baños']) ?></div>
            <div
                class="col-xs-6 col-md-4"><?= $form->field($model, 'area')->input('number', ['maxlength' => true, 'placeholder' => 'Área (opcional)'])->label("Área <span style='font-size: 12px'>(m2)</span>") ?></div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'zone_id')->dropDownList(\common\models\Zone::zonesMap(), ['prompt' => "Selecciona la zona"]) ?>
            </div>


        </div>


        <div class="row">
            <div
                class="col-xs-12"><?= $form->field($model, 'description')->textarea(['placeholder' => 'Comentarios (Opcional)', 'maxlength' => true]) ?></div>
        </div>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php \backend\assets\SaleEvents::register($this) ?>
<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 19/03/2017
 * Time: 1:34
 */
use common\components\mobile_detection\MobileDetectionComponent;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>


<?php
$isMobile = (new MobileDetectionComponent())->isMobile();
$config = [
    'action' => ['house/quick-search'],
    'method' => 'get',
];
if(isset($resultsView) && Yii::$app->get('mobile-detect')->isMobile())
    $config['fieldConfig'] = ['template' => "{input}\n{error}"];
$form = ActiveForm::begin($config); ?>

<div  class="row quick-search-content">
    <div id="homePriceSection" class="col-xs-12 col-md-5" style="<?= !$isMobile? "border-right: 1px solid #dce0e0" : ""?>">
        <div class="row">
            <div class="col-xs-6"><?= $form->field($model, 'priceMin')->input('number', ['placeholder' => 'Mínimo', 'min' => 0])->label('Precio') ?></div>
            <div class="col-xs-6"><?= $form->field($model, 'priceMax')->input('number', ['placeholder' => 'Máximo'])->label('&nbsp;') ?></div>
        </div>
    </div>

    <div id="homeLocationSection" class="col-xs-12 col-md-5"><?= $form->field($model, 'location')->input('text', ['placeholder' => 'ej : Habana playa matanzas'])->label('Lugar') ?></div>
    <div class="col-xs-12 col-md-2">
        <div class="form-group">
			<?php $style = $isMobile? "" : "margin-top: 25px"; ?>
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary btn-block', 'style' => $style , 'id' => 'quickSearchSubmitBtn']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<style>
	label{
		font-weight: bold;
	}
</style>
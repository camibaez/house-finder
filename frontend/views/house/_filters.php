<?php

use kartik\popover\PopoverX;
use kartik\slider\Slider;
use yii\helpers\Html;

kartik\popover\PopoverXAsset::register($this);
?>

<ul id="filters-div" class="nav nav-pills" style="" >

    <li role="presentation" id="price-btn-li">
        <?php
        $priceFilter = "<div class='row' id='price-fake-filters'>"
                . "<div class='col-xs-6' style='padding-right: 5px;'>"
                . Html::activeInput('number', $model, 'priceMin', ['placeholder' => 'Mínimo', 'min' => 0, 'class' => 'form-control fake-filter'])
                . "</div>"
                . "<div class='col-xs-6'  style='padding-left: 5px;'>"
                . Html::activeInput('number', $model, 'priceMax', ['placeholder' => 'Máximo', 'min' => 0, 'class' => 'form-control fake-filter'])
                . "</div>"
                . "</div>";

        $btnOptions = [
            'id' => 'price-btn-filter',
            'class' => 'btn ',
        ];

        if ($model->priceMin && $model->priceMax) {
            $btnOptions['label'] = "$" . ($model->priceMin / 1000) . "K - $" . ($model->priceMax / 1000) . "K";
            Html::addCssClass($btnOptions, "btn-success");
        } elseif ($model->priceMin) {
            $btnOptions['label'] = "> $" . ($model->priceMin / 1000) . "K";
            Html::addCssClass($btnOptions, "btn-success");
        } elseif ($model->priceMax) {
            $btnOptions['label'] = "< $" . ($model->priceMax / 1000) . "K";
            Html::addCssClass($btnOptions, "btn-success");
        } else {
            $btnOptions['label'] = "Precio";
            Html::addCssClass($btnOptions, "btn-default");
        }
        $footer = "";
        if ($model->priceMin || $model->priceMax) {
            $footer = Html::button("Limpiar", ['class' => 'btn  pull-left', 'onclick' => '$("#price-fake-filters input").val(""); ']);
        }
        $footer .= Html::submitButton("Aplicar", ['class' => 'btn btn-success']);


        echo common\widgets\FilterPopover::widget([
            'btnOptions' => $btnOptions,
            'content' => $priceFilter,
            'footer' => $footer,
        ])
        ?>
    </li>

    <li role="presentation">

        <?php
        $options = ['id' => 'sites-btn-filter'];
        $footer = Html::submitButton("Aplicar", ['class' => 'btn btn-success']);
        if ($model->checkSitesDiff()) {
            $options['label'] = "Sitios de origen (" . count($model->sites) . ")";
            $options['class'] = 'btn btn-success';
            $footer .= Html::button("Limpiar", ['class' => 'btn  pull-left', 'onclick' => '$("#sites-fake-filter input[type=\"checkbox\"]").prop("checked", true); ']);
        } else {
            $options['label'] = "Sitios de origen";
            $options['class'] = 'btn btn-default';
        }
        $sitesFilter = "<div id='sites-fake-filter'>"
                . Html::activeCheckboxList($model, 'sites', common\models\HouseSearch::sitesMap(), ['separator' => '<br>'])
                . "</div>";


        echo common\widgets\FilterPopover::widget([
            'btnOptions' => $options,
            'content' => $sitesFilter,
            'footer' => $footer,
        ])
        ?>
    </li>

    <li role="presentation">

        <?php
        $options = ['id' => 'date-btn-filter'];
        $footer = Html::submitButton("Aplicar", ['class' => 'btn btn-success']);

        if ($model->date) {
            $options['class'] = 'btn btn-success';
            //$footer .= Html::button("Limpiar", ['class' => 'btn  pull-left', 'onclick' => '$("#date-fake-filter input[type=\"option\"]").prop("checked", true); ']);
        } else {
            $options['class'] = 'btn btn-default';
        }
        $options['label'] = common\models\HouseSearch::datesMap()[$model->date];
        $dateFilter = "<div id='date-fake-filter'>"
                . Html::activeRadioList($model, 'date', common\models\HouseSearch::datesMap(), ['separator' => '<br>'])
                . "</div>";


        echo common\widgets\FilterPopover::widget([
            'btnOptions' => $options,
            'content' => $dateFilter,
            'footer' => $footer,
        ])
        ?>
    </li>

    <li role="presentation">

        <?php
        $footer = Html::submitButton("Aplicar", ['class' => 'btn btn-success']);
        $options = ['id' => 'images-btn-filter'];
        if ($model->imagesOnly) {
            $options['label'] = "Con imágenes";
            $options['class'] = 'btn btn-success';
            $footer .= Html::button("Limpiar", ['class' => 'btn  pull-left', 'onclick' => '$("#images-fake-filter input[type=\"checkbox\"]").prop("checked", false); ']);
        } else {
            $options['label'] = "Imágenes";
            $options['class'] = 'btn btn-default';
        }


        $sitesFilter = "<div id='images-fake-filter'>"
                . Html::activeCheckbox($model, 'imagesOnly', ['label' => 'Solo con imágenes'])
                . "</div>";


        echo common\widgets\FilterPopover::widget([
            'btnOptions' => $options,
            'content' => $sitesFilter,
            'footer' => $footer,
        ])
        ?>
    </li>
</ul>




<?php if($this->isMobile()) { ?>
	<style>
		#filters-div>li{
			float: none;
			display: inline-block;
		}
		#filters-div{
			overflow-x: scroll;
			white-space: nowrap;
		}
	</style>
<?php } ?>
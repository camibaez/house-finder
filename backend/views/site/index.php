<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h2 style="margin: 3px 0">Evaluation Parameters</h2></div>
                <div class="panel-body">
                    <?= Html::a("Manage evaluation parameters", ['evaluation/update-parameters'], ['class' => 'btn-lg btn btn-primary'])?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h2 style="margin: 3px 0">House search</h2></div>
                <div class="panel-body">
                    <?= Html::a("House search", ['house/search'], ['class' => 'btn-lg btn btn-primary'])?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h2 style="margin: 3px 0">Review</h2></div>
                <div class="panel-body">
                    <?= Html::a("Review", ['house/review'], ['class' => 'btn-lg btn btn-primary'])?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h2 style="margin: 3px 0">Searches</h2></div>
                <div class="panel-body">
                    <?= Html::a("Searches", ['searches/index'], ['class' => 'btn-lg btn btn-primary'])?>
                </div>
            </div>
        </div>
    </div>
</div>

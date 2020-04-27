<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SalePartial */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Sale Partial',
    ]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sale Partials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sale-partial-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

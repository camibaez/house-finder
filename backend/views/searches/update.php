<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Searches */

$this->title = 'Update Searches: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Searches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="searches-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

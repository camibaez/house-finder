<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Searches */

$this->title = 'Create Searches';
$this->params['breadcrumbs'][] = ['label' => 'Searches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="searches-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

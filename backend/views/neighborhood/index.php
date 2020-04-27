<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Neighborhoods');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="neighborhood-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Neighborhood'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_index', ['dataProvider' => $dataProvider]) ?>

</div>

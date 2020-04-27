<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Municipality */
/* @var $neighborhoods \yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->province->name, 'url' => ['province/view', 'id' => $model->province_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="municipality-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'province_id',
        ],
    ]) ?>

    <?= Html::a(Yii::t('app', 'Add Neighborhood'), ['neighborhood/create', 'municipality' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= $this->render('@backend/views/neighborhood/_index', ['dataProvider' => $neighborhoods]) ?>

</div>

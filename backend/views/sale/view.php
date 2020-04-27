<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Sale */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'price',
            'address',
            'bedroom',
            'bathroom',
            'area',
            [
                'label' => 'Provincia',
                'value' => $model->province->name,
            ],
            [
                'label' => 'Municipio',
                'value' => $model->municipality->name,
            ],
            [
                'label' => 'Barrio',
                'value' => $model->neighborhood->name,
            ],
            [
                'label' => 'Zona',
                'value' => $model->zone->name,
            ],
            [
                'label' => 'Tipo de Casa',
                'value' => $model->houseType->name,
            ],
            'user_username',
            'created_at:date:Creado',
            'updated_at:date:Actualizado',
            'status',
            'description:ntext',
            'expiration_status',
            'rank',
        ],
    ]) ?>

</div>

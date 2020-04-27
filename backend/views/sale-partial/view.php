<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SalePartial */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sale Partials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-partial-view">


    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Crear Venta'), ['../../../frontend/web/index.php/sale-partial/create', 'partialId' => $model->id,
            'email' => $model->email], ['class' => 'btn btn-primary']) ?>
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
                'value' => $model->province === null ? '(no definido)' : $model->province->name
            ],
            [
                'label' => 'Municipio',
                'value' => $model->municipality === null ? '(no definido)' : $model->municipality->name
            ],
            [
                'label' => 'Barrio',
                'value' => $model->neighborhood === null ? '(no definido)' : $model->neighborhood->name
            ],
            [
                'label' => 'Zona',
                'value' => $model->zone === null ? '(no definido)' : $model->zone->name
            ],
            [
                'label' => 'Tipo de Casa',
                'value' => $model->houseType === null ? '(no definido)' : $model->houseType->name
            ],
            'created_at:date:Creado',
            'updated_at:date:Actualizado',
            'status',
            'description:ntext',
            'email:email',
        ],
    ]) ?>

</div>

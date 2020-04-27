<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\House */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Houses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="house-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'site_id' => $model->site_id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id, 'site_id' => $model->site_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'price',
            'description:ntext',
            'site_id',
            'url:url',
            'rank',
        ],
    ])
    ?>

    <div class="row">
        <div class="col-xs-4">
            <p>Thumb</p>
            <?= Html::img("data:image/jpeg;base64," . base64_encode($model->thumb), ['alt' => 'Thumb']) ?>
        </div>
    </div>

</div>

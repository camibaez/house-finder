<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->username], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->username], [
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
            'username',
            'displayname',
            'email:email',
            'phone',
            [
                'label' => "Compras",
                'value' => $model->getPurchases()->count() . "<span style='margin-right:11px' />  " . Html::a("Ver compras", ['purchase/index' , "username" => $model->username], ['class' => 'btn btn-success']),

                'format' => 'html'
            ],
            [
                'label' => "Ventas",
                'value' => $model->getSales()->count()
            ],
            'statusName',
            'created_at:date',
            'updated_at:date',
            'roleName',
            'auth_key',
            'password_hash:ntext',
            'password_reset_token:ntext',
        ],
    ]) ?>

</div>

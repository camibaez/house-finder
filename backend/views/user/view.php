<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'displayname',
            'email:email',
            'phone',
            [
                'label' => "Compras",
                'value' => $model->getPurchases()->count() . "<span style='margin-right:11px' />  " . Html::a("Ver compras", null, ['class' => 'btn btn-success']),
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

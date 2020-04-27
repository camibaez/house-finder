<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1>Admin <?= Html::encode($this->title) ?></h1>
    <p><?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?></p>

    <div class="row">
        <div class="col-xs-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'username',
                    'displayname',
                    'email',
                    [
                      'attribute' => 'status',
                        'value' => 'statusName'
                    ],

                    'contact',
                    'created_at:date:Created',
                    'updated_at:date:Updated',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>



</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model \backend\models\Log */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Dashboard');
?>
<div class="log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <h2>General Info</h2>
            <div><label>IPs Count Accesses: <?= $model->getIpCount()?></label></div>
            <div><label>Currently Connected:</label></div>
        </div>


       


        <div class="col-lg-6">
            <h2>Sales</h2>
            <div><label>Sales Count: <?= $model->activeSalesCount?></label></div>
            <div><label>Total Sales: <?= $model->getAllSalesCount()?></label></div>

        </div>

       

        <div class="col-lg-6">
            <h2>Views</h2>
            <?= GridView::widget([
                'dataProvider' =>$model->getViewsCountMap(),
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'message:text:View',
                    'message_count:text:Accesses',
                    'message_percent:text:Percent'
                ],
            ]); ?>
        </div>



    </div>



</div>

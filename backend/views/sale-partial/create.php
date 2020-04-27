<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SalePartial */

$this->title = Yii::t('app', 'Create Sale Partial');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sale Partials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-partial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

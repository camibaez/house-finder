<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Neighborhood */

$this->title = Yii::t('app', 'Create Neighborhood');
$this->params['breadcrumbs'][] = ['label' => $model->municipality->province->name, 'url' => ['province/view', 'id' => $model->municipality->province_id]];
$this->params['breadcrumbs'][] = ['label' => $model->municipality->name, 'url' => ['municipality/view', 'id' => $model->municipality_id]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="neighborhood-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

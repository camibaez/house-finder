<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Municipality */

$this->title = Yii::t('app', 'Create Municipality');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Municipalities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="municipality-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

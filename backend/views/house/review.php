<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\House */

$this->title = 'Update House: ' . ' ' . $model->title;
?>
<div class="house-update">
    <div class="row">
        <div class='col-lg-6'>
            <div style="<?= $this->isMobile()? 'height: calc(50vh - 30px); overflow-y: scroll' : ''?>">
                <p><b><?= $model->title ?></b> <?= $model->description ?></p>

            </div>
        </div>
        <div class='col-lg-6'>
            <p><?= Html::a($model->site_id, $model->url, ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']) ?></p>
            <div style="<?= $this->isMobile()? 'height: calc(50vh - 30px); overflow-y: scroll' : ''?>">
                <?=
                $this->render('_form', [
                    'model' => $model,
                ])
                ?>
            </div>
        </div>


    </div>


</div>

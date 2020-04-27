<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Agent Manage';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="jumbotron">
                <?php
                $class = 'btn btn-lg col-xs-6 col-xs-offset-3 ';
                if ($model->daemon_mode)
                    echo $model->alive ? Html::a("Kill", ['matchmaker/set-alive', 'alive' => 0], ['class' => $class . 'btn-danger']) :
                        Html::a("Turn On", ['matchmaker/set-alive', 'alive' => 1], ['class' => $class . 'btn-success']);
                else
                    echo Html::a("Run", ['matchmaker/set-alive', 'alive' => 1], ['class' => $class . 'btn-success']);
                ?>
            </div>
            <br><br>


            <div class="col-xs-12">
                <?php $form = ActiveForm::begin([
                    'fieldConfig' => ['template' => "{input}"]
                ]); ?>


                <table id="configTable" class="table table-striped table-bordered">
                    <tbody>
                    <tr id="aliveRow" <?= !$model->daemon_mode ? "hidden=''" : '' ?>>
                        <td>Alive</td>
                        <td>
                            <div id="aliveBtns" class="boolean-div">
                                <div style="padding-right: 15px">OFF</div>
                                <div><?= $form->field($model, 'alive')->input('range', ['max' => 1, 'min' => 0, 'step' => 1]) ?> </div>
                                <div style="padding-left: 15px">ON</div>
                            </div>
                        </td>
                    </tr>
                    <tr id="asdaemonRow">
                        <td>As Daemon</td>
                        <td>
                            <div id="asdaemonBtns" class="boolean-div">
                                <div style="padding-right: 15px">OFF</div>
                                <div><?= $form->field($model, 'daemon_mode')->input('range', ['max' => 1, 'min' => 0, 'step' => 1]) ?> </div>
                                <div style="padding-left: 15px">ON</div>
                            </div>
                        </td>
                    </tr>

                    <tr id="doneRow" <?= $model->daemon_mode ? "hidden=''" : '' ?>>
                        <td>Done</td>
                        <td>
                            <div id="doneBtns" class="boolean-div">
                                <div style="padding-right: 15px">OFF</div>
                                <div><?= $form->field($model, 'done')->input('range', ['max' => 1, 'min' => 0, 'step' => 1]) ?> </div>
                                <div style="padding-left: 15px">ON</div>
                            </div>
                        </td>
                    </tr>
                    <tr <?= !$model->daemon_mode ? "hidden=''" : '' ?>>
                        <td>Sleep Time (sec)</td>
                        <td><?= $form->field($model, 'sleepTime')->input('number', ['max' => 3600, 'min' => 5, 'step' => 1]) ?></td>
                    </tr>
                    <tr>
                        <td>Matching Time</td>
                        <td><?= $form->field($model, 'lastMatchingTime')->input('number') ?></td>
                    </tr>

                    </tbody>
                </table>


                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>


            </div>
        </div>

    </div>
</div>


<style>
    #configTable .form-group {
        margin: 0;
    }

    .boolean-div div {
        float: left;
    }

    .boolean-div input {
        width: 70px;
    }

    #configTable input {
        max-width: 150px;
    }
</style>

<?php \backend\assets\JSEventsAsset::register($this); ?>
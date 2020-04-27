<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $userModel common\models\User */
/* @var $validationModel \frontend\models\UserValidation */
/* @var $rolesList Role[] */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($validationModel, 'username')->textInput(['value' => $userModel->username]) ?>

    <?= $form->field($validationModel, 'displayname')->textInput(['value' => $userModel->displayname]) ?>

    <?= $form->field($validationModel, 'email')->textInput(['value' => $userModel->email]) ?>



    <?= $form->field($validationModel, 'password')->passwordInput() ?>
    <?= $form->field($validationModel, 'password_repeat')->passwordInput() ?>

    <?= $form->field($validationModel, 'status')->dropDownList(\common\models\User::statusNameMap(), ['value' => $userModel->status]) ?>

        <div class="form-group">
            <label class="control-label" for="role">Seleccion de Rol</label>
            <?=    Html::dropDownList('roleName', null, $rolesList, ['class' => 'form-control']); ?>
        </div>

    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update') , ['class' => 'btn btn-success' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

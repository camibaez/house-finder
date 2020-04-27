<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $userModel common\models\User */
/* @var $rolesList Role[] */
/* @var $validationModel \frontend\models\UserValidation */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User',
]) . ' ' . $userModel->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $userModel->username, 'url' => ['view', 'id' => $userModel->username]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_update_form', [
        'userModel' => $userModel,
        'validationModel' => $validationModel,
        'rolesList' => $rolesList,
    ]) ?>

</div>

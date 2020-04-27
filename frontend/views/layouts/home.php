<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
Yii::info($this->title, 'statistics\views');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" >
    <head>
		
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	
        <meta charset="<?= Yii::$app->charset ?>">
		
        <meta name="description" content="El primer motor de búsquedas de casas en venta de Cuba.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="GUXKIpY0KhBxopRhOWuFYNs8uMb3yzjSrJaWLmw0f6s" />
        <link href="<?= \yii\helpers\Url::base() ?>/img/favicon.png" rel="icon" >
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>


    </head>
    <body style="background-color: #f7f7f7">
        <?php $this->beginBody() ?>

        <div class="wrap" style="">


            <div class="container" style="padding-top: 50px">

                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <?= $this->render("_footer") ?>

                <?php  $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

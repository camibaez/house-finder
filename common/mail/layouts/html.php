<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
        body{
            background-color: #f4f4f4;
            color: #333;
        }
        .btn {
            border-radius: 0;
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
        }

        .btn-success {
            color: #fff;
            background-color: #004d80;
            border-color: #004d80;
        }
    </style>


</head>
<body>
    <?php $this->beginBody() ?>
    <?= $content ?>

    <hr>
    <div class="about-section" style="font-size: 12px; text-align: center">
        <p>Este mensaje fue enviado por 
            <span><?= Html::a("venderor.com", "http://venderor.com")?></span>

        </p>
       
    </div>


    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

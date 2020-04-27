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
\frontend\assets\JSAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" itemscope itemtype="http://schema.org/WebPage">
    <head>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
        <link href="<?= \yii\helpers\Url::base() ?>/img/favicon.png" rel="icon" >
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <nav class="navbar-fixed-top navbar material-shadow" style="min-height: 55px">
                <div class="hidden-xs" style="width: 45px;height: 45px;position:  fixed;left: 24px;top: 5px;">
                    <?= Html::a(Html::img(\yii\helpers\Url::base() . "/img/favicon.png", ['style' => 'width: 100%']), ['site/index'], ['class' => '']) ?>
                </div>
                <div class="container" style="text-align: right; padding-top: 5px; padding-bottom: 5px">
                    <div class="hidden-md hidden-lg pull-left" style="margin-right: 8px; width: 40px;height: 34px; display: inline-block">
                        <?= Html::a(Html::img(\yii\helpers\Url::base() . "/img/favicon.png", ['style' => 'width: 100%']), ['site/index'], ['class' => '']) ?>
                    </div>
                    <?php
                    $params = Yii::$app->request->get();
                    if ($params)
                        $btnUrl = ['house/search'] + $params;
                    else
                        $btnUrl = ['site/index'];
                    echo yii\helpers\Html::a("<span class='glyphicon glyphicon-search'></span> Volver a la búsqueda", $btnUrl, ['class' => 'btn pull-left', 'style' => 'padding-left: 0; font-size: 15px; padding-bottom: 0']);


                    $params = Yii::$app->request->get();
                    echo Nav::widget([
                        'items' => [
                            [
                                'label' => "<span class='glyphicon glyphicon-stats'></span>",
                                'url' => ['house/graphics'] + $params,
                                'encode' => false,
                                'linkOptions' => ['class' => 'btn btn-default']
                            ],
                            [
                                'label' => "<span class='glyphicon glyphicon-heart'></span>",
                                'url' => ['house/favs-index'] + $params,
                                'encode' => false,
                                'linkOptions' => ['class' => 'btn btn-default']
                            ],
                        ],
                        'options' => ['class' => 'nav-pills pull-right']
                    ]);
                    ?>
                </div>
            </nav>


            <div class="container" style="padding-top: 60px">

                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <?= $this->render("_footer") ?>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
<?php Yii::info($this->title, 'statistics\views'); ?>
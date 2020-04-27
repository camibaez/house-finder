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
Yii::info($this->title, 'statistics\views');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" itemscope itemtype="http://schema.org/WebPage">
    <head>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <meta charset="<?= Yii::$app->charset ?>">
        <link rel="canonical" href="http://www.venderor.com/house/search" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#317EFB"/>
        <link href="<?= \yii\helpers\Url::base() ?>/img/favicon.png" rel="icon" >
        
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <nav class="navbar-fixed-top navbar material-shadow" style="<?= $this->isMobile() ? 'padding-top: 0; position: inherit; margin-bottom: 0' : '' ?>">
                <div class="hidden-xs" style="width: 45px;height: 45px;position:  fixed;left: 24px;top: 9px;">
                    <?= Html::a(Html::img(\yii\helpers\Url::base() . "/img/favicon.png", ['style' => 'width: 100%']), ['site/index'], ['class' => '']) ?>
                </div>
                <div class="container" style="padding-top: <?= $this->isMobile() ? '3px' : '5px' ?>; padding-bottom: 3px">

                    <div class="row">
                        <div class="col-xs-12 hidden-md hidden-lg" style="text-align: center; padding-bottom: 5px">
                            <?= Html::a(Html::img(\yii\helpers\Url::base() . "/img/logo.png", ['style' => 'width: 104px;']), ['site/index'], ['class' => '']) ?>

                            <?php
                            $params = Yii::$app->request->get();
                            $btnUrl = ['house/graphics'] + $params;
                                                        $btnUrl = ['house/favs-index'] + $params;
                            $favs = isset($_COOKIE['favs-ids']) ? $_COOKIE['favs-ids'] : '';
                            if ($favs) {
                                $count = count(explode(",", $favs));
                                $favsButtonText = "<span class='glyphicon glyphicon-heart'></span><span class='badge' style='position: absolute'>$count</span>";
                            } else {
                                $favsButtonText = "<span class='glyphicon glyphicon-heart'></span>";
                            }
                            
                            $navsBtns =  Nav::widget([
                                'items' => [
                                    [
                                        'label' => "<span class='glyphicon glyphicon-stats'></span>",
                                        'url' => ['house/graphics'] + $params,
                                        'encode' => false,
                                        'linkOptions' => ['class' => 'btn btn-default']
                                    ],
                                    [
                                        'label' => $favsButtonText,
                                        'url' => ['house/favs-index'] + $params,
                                        'encode' => false,
                                       'linkOptions' => ['class' => 'btn btn-default']
                                    ],
                                ],
                                'options' => ['class' => 'nav-pills pull-right menu-pills']
                            ]);
                            echo $navsBtns;
                            ?>

                        </div>

                        <div class="col-xs-12 col-md-6">
                            <?=
                            $this->render('@frontend/views/house/_quick_search_form', [
                                'model' => $this->params['searchModel'],
                                'resultsView' => true
                            ]);
                            ?>
                        </div>
                        <div class="hidden-xs col-md-6" style="text-align: right"> 
                            <?php
                             echo $navsBtns;
                            ?>
                        </div>

                    </div>




                </div>
            </nav>

            <div class="container" style="<?= $this->isMobile() ? 'padding-top: 0px;' : 'padding-top: 100px' ?>">

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

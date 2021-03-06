<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\HouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Houses';
?>
<div class="house-index">

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="row">
        <div class="col-xs-12">
            <?php
            if (!$this->isMobile())
                echo '<div class="light-wrapper" style="padding-left: 10px; padding-right: 10px">';
            echo $this->render('_quick_search_form', ['model' => $searchModel, 'resultsView' => true]);
            if (!$this->isMobile())
                echo '</div>';
            ?>
        </div>
    </div>

    
    <br>
    <?= Html::a("Unsafe", ['house/search-unsafe'], ['class' => 'btn btn-primary'])?>
    <?= Html::a("Review", ['house/review'], ['class' => 'btn btn-primary'])?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => "Title",
                'value' => function($data) {
                    return Html::a($data['title'], $data['url']);
                },
                'format' => 'html'
            ],
            'price',
            [
                'label' => 'Description',
                'value' => function ($data) {
                    return yii\helpers\StringHelper::truncate($data['description'], 300);
                },
            ],
            [
                'label' => "Rank",
                'value' => function($data) {
                    return Yii::$app->formatter->asDecimal($data['r_rank'], 3);
                }
            ],
            [
                'label' => "Images",
                'value' => function($data) {
                    $links = \common\models\House::findOne($data['id'])->getThumbsLinks();
                    if ($links) {
                        $imageString = file_get_contents($links[0]);
                        $imageString = base64_encode($imageString);
                        return Html::img("data:image/jpeg;base64," . $imageString, ['alt' => "House image", 'style' => "width: 100%;"]);
                    }
                    return null;
                },
                'format' => 'raw'
            ],
                        [
                          'label' => "Status",
                            'value' => function($data){
                                return $data['status'];
                            }
                        ],
            /*
              'description:ntext',
              /*
              [
              'label' => 'Province',
              'value' => function($data) {
              if ($data['province_id'])
              return \common\models\Province::findOne($data['province_id'])->name;
              else
              return null;
              }
              ],
              [
              'label' => 'Municipality',
              'value' => function($data) {
              if ($data['municipality_id'])
              return \common\models\Municipality::findOne($data['municipality_id'])->name;
              else
              return null;
              }
              ],
              [
              'label' => 'Neighborhood',
              'value' => function($data) {
              if ($data['neighborhood_id'])
              return \common\models\Neighborhood::findOne($data['neighborhood_id'])->name;
              else
              return null;
              }
              ],

              'url:url',
              //'rank',
              //'site_id',
              [
              'label' => "Rank",
              'value' => function($data){
              return Yii::$app->formatter->asDecimal($data['r_rank'],3);
              }
              ],

             */
            [
                'class' => 'yii\grid\ActionColumn',
                
                'urlCreator' => function($action, $model, $key, $index, $col){
                    return yii\helpers\Url::to(["$action", 'id' => $model['id'], 'site' => $model['site_id']]);
                },
            ],
        ],
    ]);
    ?>

</div>

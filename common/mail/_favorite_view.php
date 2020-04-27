<div class="favorite-element">
    <h3>
        <?php
            $text = '$' . $model->price . " - " .  yii\helpers\StringHelper::truncate($model->title, 100);
            echo yii\helpers\Html::a($text, $model->url);
        ?>
    </h3>
    <p><?= yii\helpers\StringHelper::truncate($model->description, 200) ?></p>
</div>
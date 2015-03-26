<?php
use yii\helpers\Html;
?>
<div class="text-center">
    <?= Html::img($model->getImageUrl(), [
        'class'=>'img-thumbnail',
        'alt'=>$model->name,
        'title'=>$model->name
    ]); ?>
</div>
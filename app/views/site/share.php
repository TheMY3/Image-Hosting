<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="text-center">
    <?= Html::img($model->getImageUrl(), [
        'class'=>'img-thumbnail',
        'alt'=>$model->name,
        'title'=>$model->name
    ]); ?>
</div>
<h3>Поделитесь изображением <small class="pull-right">покажите друзьям!</small></h3>
<hr>
<div class = "share_block">
    <div class = "share_text">Социальные сети:</div>
    <div class="share_content share42init" data-url="<?= Yii::$app->request->url;?>" data-title="<?= Yii::$app->name;?>" data-description="<?= Yii::$app->name;?>" data-image="<?= $model->getImageUrl();?>"></div>
</div>
<h3>Превью + ссылка <small class="pull-right">вставка или отправка изображения с превью</small></h3>
<hr>
<div class="row form-horizontal">
    <div class="col-sm-3 control-label">
        BBCode:
    </div>
    <div class="col-sm-7">
        <?= Html::input(null, 'bbcode', '[url='.Url::toRoute(['image', 'link' => $link]).'][img]'.$model->getImageUrl().'[/img][/url]', ['class' => 'form-control']); ?>
    </div>

    <div class="col-sm-3 control-label">
        HTML:
    </div>
    <div class="col-sm-7">
        <?= Html::input(null, 'html', '<a href="'.Url::toRoute(['image', 'link' => $link]).'"><img src="'.$model->getImageUrl().'" border="0" /></a>', ['class' => 'form-control']); ?>
    </div>
</div>
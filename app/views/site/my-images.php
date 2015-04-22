<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\PseudoCrypt;

/* @var $this \yii\web\View */
/* @var $model \app\models\Images */
$this->title = Yii::$app->name.' - Мои изображения';
?>
<div class="gallery-block">
    <?php if($data->count > 0) : ?>
        <ul class="gallery-list">
        <?php foreach($data->models as $image) : ?>
            <li>
                <a href="<?= Url::toRoute(['image', 'link' => PseudoCrypt::hash($image->id, 6)]);?>">
                    <?= Html::img($image->getImageUrl(), [
                        'class' => 'img-rounded',
                        'alt' => $image->name,
                        'title' => $image->name,
                        'width' => 280,
                        'height' => 280,
                    ]); ?>
                </a>
                <div class="image-info">
                    <?= Html::a('<i class="fa fa-pencil"></i>', ['image-edit', 'link' => PseudoCrypt::hash($image->id, 6)]);?>
                    <i class="fa fa-eye"></i> <?= $image->views; ?>
                    <i class="fa fa-thumbs-up"></i> <?= $image->likes; ?>
                    <i class="fa fa-calendar"></i> <?= date('d.m.y', $image->created); ?>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
        <div class="col-sm-12 text-center">
            <?= yii\widgets\LinkPager::widget([
                'pagination' => $data->pagination,
                'firstPageCssClass' => 'hidden',
                'prevPageCssClass' => 'prev',
                'nextPageCssClass' => 'next',
                'lastPageCssClass' => 'hidden',
                'activePageCssClass' => 'active',
                'disabledPageCssClass' => 'disabled',
                'maxButtonCount' => '3',
                'options' => ['class' => 'pagination'],
            ]) ?>
        </div>
    <?php else : ?>
        <p><?= Yii::t('app', 'Картинок пока нет') ?></p>
    <?php endif; ?>
</div>
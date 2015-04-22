<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this \yii\web\View */
/* @var $model \app\models\Images */
/* @var $form yii\bootstrap\ActiveForm */
$this->title = Yii::$app->name.' - Редактирование изображения';
?>
    <div class="image-edit_block">
        <div class="row">
            <div class="col-xs-4 text-center">
                <?= Html::img($model->getImageUrl(), [
                    'class' => 'img-thumbnail',
                    'alt' => $model->name,
                    'title' => $model->name
                ]); ?>
            </div>
            <div class="col-xs-8">
                <p><i class="fa fa-calendar"></i> Добавлено: <?= date('H:i d.m.y', $model->created); ?></p>
                <p><i class="fa fa-thumbs-up"></i> Понравилось: <?= $model->likes; ?></p>
                <p><i class="fa fa-eye"></i> Просмотров: <?= $model->views; ?></p>
                <p>Название: <?= $model->name; ?></p>
                <p>Описание: <?= $model->description; ?></p>
                <?= Html::a('Delete image', ['image-delete', 'link'=>$link], ['class'=>'btn btn-danger', 'data-method' => 'post', 'data-confirm' => 'Удалить изображение?']);?>
            </div>
        </div>
    </div>
<?php
$this->registerJs("
    $('[data-toggle=\"tooltip\"]').tooltip()
", \yii\web\View::POS_READY);
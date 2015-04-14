<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this \yii\web\View */
/* @var $model \app\models\Images */
/* @var $form yii\bootstrap\ActiveForm */
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
                <p><i class="fa fa-calendar"></i> Uploaded: <?= date('H:i d.m.y', $model->created); ?></p>
                <p><i class="fa fa-thumbs-up"></i> Likes: <?= $model->likes; ?></p>
                <p><i class="fa fa-eye"></i> Watches: <?= $model->views; ?></p>
                <p>Name: <?= $model->name; ?></p>
                <p>Description: <?= $model->description; ?></p>
                <?= Html::a('Delete image', ['image-delete', 'link'=>$link], ['class'=>'btn btn-danger', 'data-method' => 'post', 'data-confirm' => 'Delete?']);?>
            </div>
        </div>
    </div>
<?php
$this->registerJs("
    $('[data-toggle=\"tooltip\"]').tooltip()
", \yii\web\View::POS_READY);
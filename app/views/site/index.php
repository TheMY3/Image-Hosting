<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\components\PseudoCrypt;

/* @var $this yii\web\View */
$this->title = Yii::$app->name;
?>
<div class="site-index">
    <div class="jumbotron">
        <h1><?= $this->title;?></h1>
        <p class="lead">Загружайте и делитесь изображениями.</p>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->field($model, 'image')->fileInput(['id' => 'file-upload', 'accept' => 'image/*'])->label(false); ?>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h2>Преимущества:</h2>
                <p>
                    <ul>
                        <li>Не требует регистрации</li>
                        <li>Хранение фотографий неограниченно долго</li>
                        <li>Получение ссылки для вставки загруженной фотографии в блог, форум, любой другой сайт в интернете или отправки по электронной почте.</li>
                        <li>Максимальный объем загружаемого файла до 5Мб</li>
                        <li>Сервис полностью бесплатен</li>
                    </ul>
                </p>
            </div>
            <div class="col-lg-8">
                <h2 class="text-center">Добавлены недавно:</h2>
                <div id="slides-block">
                    <?php foreach($slides as $slide) : ?>
                        <div class="item">
                            <a href="<?= Url::toRoute(['image', 'link' => PseudoCrypt::hash($slide->id, 6)]);?>">
                                <?= Html::img($slide->getImageUrl(), [
                                    'class' => 'img-rounded',
                                    'alt' => $slide->name,
                                    'title' => $slide->name,
                                    'width' => 180,
                                    'height' => 180,
                                ]); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Просто подключаем один файл:
//$this->registerJsFile('@app/assets/js/script.js', self::POS_READY);
//$this->registerCssFile('@app/vendor/katrik-v/bootstrap-fileinput/fileinput.css');

$this->registerJs("
$('#slides-block').owlCarousel({
      autoPlay: 3000, //Set AutoPlay to 3 seconds
      items : 3,
      stopOnHover: true,
      loop: true,
      lazyLoad : true,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]
  });

$('#file-upload').fileinput({
    browseClass: 'btn btn-lg btn-success',
    showCaption: false,
    showRemove: false,
    showUpload: true,
    allowedFileTypes: ['image'],
    allowedFileExtensions: ['jpg', 'gif', 'png', 'bmp']
});
", \yii\web\View::POS_READY);
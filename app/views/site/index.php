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
        <?php if (!Yii::$app->user->isGuest):?>
            <div class="col-md-12">
                <hr/>
                Text
            </div>
        <?php endif;?>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <h2>О фотохостинге:</h2>
                <p>
                    На WAPICS.RU вы можете размещать изображения и получать код для размещения затем изображений у себя на сайте, в блоге и форуме.
                    Разрешается размещение любых изображений, не нарушающих действующее законодательство.
                </p>
                <p>
                    Внимание! Полностью запрещено размещение изображений, содержащих:
                    <ul>
                        <li>половые акты (в том числе рисунки);</li>
                        <li>мужские или женские гениталии крупно (в том числе рисунки);</li>
                        <li>детей или несовершеннолетних в обнажённом виде;</li>
                        <li>фото, большую часть которых занимают матерные выражения (в том числе рисунки);</li>
                        <li>фото (карты) мест, где заложены наркотики и другие подобные запрещённые вещества;</li>
                        <li>фото трупов или расчленённых тел (информацию о разместившем такие материалы мы передаём в правоохранительные органы).</li>
                    </ul>
                </p>
            </div>
            <div class="col-md-12">
                <hr>
                <h2>Статистика:</h2>
                <div class="row">
                    <div class="col-sm-6">
                        <p>Загружено за сутки: <?= $data['today'];?></p>
                        <p>Загружено за неделю: <?= $data['week'];?></p>
                    </div>
                    <div class="col-sm-6">
                        <p>Загружено за месяц: <?= $data['mounth'];?></p>
                        <p>Загружено за всё время: <?= $data['all'];?></p>
                    </div>
                </div>
            </div>
<!--            <div class="col-lg-6">-->
<!--                <h2>Преимущества:</h2>-->
<!--                <p>-->
<!--                    <ul>-->
<!--                        <li>Не требует регистрации</li>-->
<!--                        <li>Хранение фотографий неограниченно долго</li>-->
<!--                        <li>Получение ссылки для вставки загруженной фотографии в блог, форум, любой другой сайт в интернете или отправки по электронной почте.</li>-->
<!--                        <li>Максимальный объем загружаемого файла до 5Мб</li>-->
<!--                        <li>Сервис полностью бесплатен</li>-->
<!--                    </ul>-->
<!--                </p>-->
<!--            </div>-->
<!--            <div class="col-lg-6">-->
<!--                <h2>Статистика:</h2>-->
<!--                <p>-->
<!--                    <ul>-->
<!--                        <li>Загружено за сутки: 0</li>-->
<!--                        <li>Просмотров за сутки: 0</li>-->
<!--                        <li>Загрузок за всё время: 0</li>-->
<!--                        <li>Просмотров за всё время: 0</li>-->
<!--                    </ul>-->
<!--                </p>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>

<?php
$this->registerJs("
$('#file-upload').fileinput({
    browseClass: 'btn btn-lg btn-success',
    showCaption: false,
    showRemove: false,
    showUpload: true,
    allowedFileTypes: ['image'],
    allowedFileExtensions: ['jpg', 'gif', 'png', 'bmp']
});
", \yii\web\View::POS_READY);
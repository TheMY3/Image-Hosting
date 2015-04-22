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
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']]); ?>
        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*'])->label(false); ?>
        <?php if (!Yii::$app->user->isGuest):?>
            <div class="text-left">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#effects-list" aria-expanded="true" aria-controls="collapseOne">
                                    Дополнительные настройки
                                </a>
                            </h4>
                        </div>
                        <div id="effects-list" class="panel-collapse collapse" role="tabpanel">
                            <div class="panel-body">
                                <?= $form->field($model, 'name', ['template' => '<div class="col-md-3">{label}</div><div class="col-md-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Введите название']); ?>
                                <?= $form->field($model, 'status', ['template' => '<div class="col-md-12">{label}{input}{hint}{error}</div>'])->checkbox(); ?>
                                <?= $form->field($model, 'watermark', ['template' => '<div class="col-md-12">{label}{input}{hint}{error}</div>'])->checkbox(); ?>
                                <?= $form->field($model, 'size', ['template' => '<div class="col-md-12">{label}{input}{hint}{error}</div>'])->checkbox(); ?>
                                <?= $form->field($model, 'size_height', ['template' => '<div class="col-md-3">{label}</div><div class="col-md-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Высота в px']); ?>
                                <?= $form->field($model, 'size_width', ['template' => '<div class="col-md-3">{label}</div><div class="col-md-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Ширина в px']); ?>
                                <?= $form->field($model, 'rotate', ['template' => '<div class="col-md-12">{label}{input}{hint}{error}</div>'])->checkbox(); ?>
                                <?= $form->field($model, 'rotate_value', ['template' => '<div class="col-md-3">{label}</div><div class="col-md-9">{input}{hint}{error}</div>'])->dropDownList($rotate); ?>
                                <?= $form->field($model, 'flip', ['template' => '<div class="col-md-12">{label}{input}{hint}{error}</div>'])->checkbox(); ?>
                                <?= $form->field($model, 'flip_value', ['template' => '<div class="col-md-3">{label}</div><div class="col-md-9">{input}{hint}{error}</div>'])->dropDownList($flip); ?>
                                <?= $form->field($model, 'negattive', ['template' => '<div class="col-md-12">{label}{input}{hint}{error}</div>'])->checkbox(); ?>
                                <?= $form->field($model, 'grayscale', ['template' => '<div class="col-md-12">{label}{input}{hint}{error}</div>'])->checkbox(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="panel panel-default text-left">
                <div class="panel-heading" role="tab">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#effects-list" aria-expanded="true" aria-controls="collapseOne">
                            Дополнительные настройки
                        </a>
                    </h4>
                </div>
                <div id="effects-list" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <?= $form->field($model, 'status', ['template' => '<div class="col-md-12">{label}{input}{hint}{error}</div>'])->checkbox(); ?>
                        <?= $form->field($model, 'watermark', ['template' => '<div class="col-md-12">{label}{input}{hint}{error}</div>'])->checkbox(['disabled' => 'disabled']); ?>
                        <span class="text-success">После регистрации Вам будет доступно больше возможностей</span>
                    </div>
                </div>
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
$('.field-images-size_height').hide();
$('.field-images-size_width').hide();
$('.field-images-rotate_value').hide();
$('.field-images-flip_value').hide();

$('#images-image').fileinput({
    browseClass: 'btn btn-lg btn-success',
    showCaption: false,
    showRemove: false,
    showUpload: true,
    allowedFileTypes: ['image'],
    allowedFileExtensions: ['jpg', 'gif', 'png', 'bmp']
});

$(document).on('change', '#images-size', function(){
    var checked = $(this).is(':checked');
    if (checked) {
        $('.field-images-size_height').show();
        $('.field-images-size_width').show();
    }
    else {
        $('.field-images-size_height').hide();
        $('.field-images-size_width').hide();
    }
});

$(document).on('change', '#images-rotate', function(){
    var checked = $(this).is(':checked');
    if (checked) {
        $('.field-images-rotate_value').show();
    }
    else {
        $('.field-images-rotate_value').hide();
    }
});

$(document).on('change', '#images-flip', function(){
    var checked = $(this).is(':checked');
    if (checked) {
        $('.field-images-flip_value').show();
    }
    else {
        $('.field-images-flip_value').hide();
    }
});
", \yii\web\View::POS_READY);
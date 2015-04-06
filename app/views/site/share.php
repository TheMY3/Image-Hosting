<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
    <div class="text-center">
        <?= Html::img($model->getImageUrl(), [
            'class' => 'img-thumbnail',
            'alt' => $model->name,
            'title' => $model->name
        ]); ?>
    </div>
    <h3 class="share-title"><div class="share-title_text">Поделитесь изображением</div>
        <div class="share-title_descr">покажите друзьям!</div>
    </h3>
    <hr>
    <div class="share_block">
        <div class="share_text">Социальные сети:</div>
        <div class="share_content share42init" data-url="<?= Yii::$app->request->url; ?>"
             data-title="<?= Yii::$app->name; ?>" data-description="I shared my image at <?= Yii::$app->name; ?>"
             data-image="<?= $model->getImageUrl(); ?>"></div>
    </div>
    <h3 class="share-title"><div class="share-title_text"><i class="fa fa-share"></i> Показать изображение</div>
        <div class="share-title_descr">подходит для форумов и чатов</div>
    </h3>
    <hr>
    <div class="form-horizontal">
        <div class="row mb_20px">
            <div class="col-md-6 col-sm-12">
                <div class="col-sm-12 control-label share-label">
                    Ссылка на просмотр:
                </div>
                <div class="col-lg-8 col-sm-7 col-xs-12">
                    <?= Html::input(null, 'link', Yii::$app->request->hostInfo . Url::toRoute(['image', 'link' => $link]), ['class' => 'form-control']); ?>
                </div>
                <div class="col-lg-4 col-sm-5 col-xs-12">
                    <button class="btn btn-primary btn-block copy-button">Copy to Clipboard</button>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="col-sm-12 control-label share-label">
                    Ссылка на изображение:
                </div>
                <div class="col-lg-8 col-sm-7 col-xs-12">
                    <?= Html::input(null, 'link', Yii::$app->request->hostInfo . $model->getImageUrl(), ['class' => 'form-control']); ?>
                </div>
                <div class="col-lg-4 col-sm-5 col-xs-12">
                    <button class="btn btn-primary btn-block copy-button">Copy to Clipboard</button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h3 class="share-title"><div class="share-title_text"><i class="fa fa-external-link"></i> Превью + ссылка</div>
        <div class="share-title_descr">вставка или отправка изображения с превью</div>
    </h3>
    <hr>
    <div class="form-horizontal">
        <div class="row mb_20px">
            <div class="col-md-6 col-sm-12">
                <div class="col-sm-12 control-label share-label">
                    BBCode:
                </div>
                <div class="col-lg-8 col-sm-7 col-xs-12">
                    <?= Html::input(null, 'bbcode', '[url=' . Yii::$app->request->hostInfo . Url::toRoute(['image', 'link' => $link]) . '][img]' . Yii::$app->request->hostInfo . $model->getImageUrl() . '[/img][/url]', ['class' => 'form-control']); ?>
                </div>
                <div class="col-lg-4 col-sm-5 col-xs-12">
                    <button class="btn btn-primary btn-block copy-button">Copy to Clipboard</button>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="col-sm-12 control-label share-label">
                    HTML:
                </div>
                <div class="col-lg-8 col-sm-7 col-xs-12">
                    <?= Html::input(null, 'html', '<a href="' . Yii::$app->request->hostInfo . Url::toRoute(['image', 'link' => $link]) . '"><img src="' . Yii::$app->request->hostInfo . $model->getImageUrl() . '" border="0" /></a>', ['class' => 'form-control']); ?>
                </div>
                <div class="col-lg-4 col-sm-5 col-xs-12">
                    <button class="btn btn-primary btn-block copy-button">Copy to Clipboard</button>
                </div>
            </div>
        </div>
    </div>
<!--    <hr>-->
<!--    <h3 class="share-title"><div class="share-title_text"><i class="fa fa-envelope-o"></i> Отправить ссылку на Email</div>-->
<!--        <div class="share-title_descr">отправка ссылки на Email</div>-->
<!--    </h3>-->
<!--    <hr>-->
<!--    <div class="form-horizontal">-->
<!--        <div class="row mb_20px">-->
<!--            <div class="col-sm-12">-->
<!--                <div class="col-sm-2 control-label share-label">-->
<!--                    Укажите Email:-->
<!--                </div>-->
<!--                <div class="col-sm-7">-->
<!--                    --><?//= Html::input(null, 'email', null, ['class' => 'form-control', 'placeholder' => 'Enter email']); ?>
<!--                </div>-->
<!--                <div class="col-sm-3">-->
<!--                    <button class="btn btn-primary btn-block copy-button">Send</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php
$this->registerJsFile('/app/media/js/ZeroClipboard.js', ['position' => \yii\web\View::POS_END]);
$this->registerJs("
    var client = new ZeroClipboard( document.getElementsByClassName('copy-button') );

    client.on( 'ready', function( readyEvent ) {
//        alert( 'ZeroClipboard SWF is ready!' );

        client.on( 'copy', function (event) {
            var clipboard = event.clipboardData;
            var data = $(event.target).parent().prev().find('input').val();
            clipboard.setData( 'text/plain', data );
        });

        client.on( 'aftercopy', function( event ) {
            // `this` === `client`
            // `event.target` === the element that was clicked
//            $(event.target).notify('Ссылка скопирована в буфер обмена', {className: 'success',position:'top'});
            $.notify('Ссылка скопирована в буфер обмена', 'success');
//            event.target.style.display = 'none';
//            alert('Copied text to clipboard: ' + event.data['text/plain'] );
        });
    });
    ", \yii\web\View::POS_READY);
<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $model \app\models\Images */
?>
    <div class="image-view_block">
        <div class="image-view_image">
            <?= Html::img($model->getImageUrl(), [
                'class' => 'img-thumbnail',
                'alt' => $model->name,
                'title' => $model->name
            ]); ?>
        </div>
        <hr>
        <div class="image-view_info">
            <div class="pull-left">
                <div class="user-block">
                    <i class="fa fa-user"></i> Добавил: <?= $model->id_user ? $model->user->username  : 'Гость'; ?>
                </div>
            </div>
            <div class="pull-right">
                <div class="date-block"><i class="fa fa-calendar"></i> <?= date('d.m.y', $model->created); ?></div>
                <a class="like-link<?= isset(Yii::$app->request->cookies['image_like_'.$link]) ? ' active' : '' ?>"><i class="fa fa-thumbs-up"></i> <span><?= $model->likes; ?></span></a>
                <div class="view-count"><i class="fa fa-eye"></i> <?= $model->views; ?></div>
                <a class="share-link" data-toggle="tooltip" data-placement="top" title="Share image"><i class="fa fa-share"></i></a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="image-view_share">
            <hr>
            <h3 class="share-title">
                <div class="share-title_text">Поделитесь изображением</div>
                <div class="share-title_descr">покажите друзьям!</div>
            </h3>
            <hr>
            <div class="share_block">
                <div class="share_text">Социальные сети:</div>
                <div class="share_content share42init" data-url="<?= Yii::$app->request->url; ?>"
                     data-title="<?= Yii::$app->name; ?>"
                     data-description="I shared my image at <?= Yii::$app->name; ?>"
                     data-image="<?= $model->getImageUrl(); ?>"></div>
            </div>
            <h3 class="share-title">
                <div class="share-title_text"><i class="fa fa-share"></i> Показать изображение</div>
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
            <h3 class="share-title">
                <div class="share-title_text"><i class="fa fa-external-link"></i> Превью + ссылка</div>
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
        </div>
        <hr>
        <div id="disqus_thread"></div>
    </div>
<?php
$this->registerJsFile('/app/media/js/ZeroClipboard.js', ['position' => \yii\web\View::POS_END]);
$this->registerJs("
    var disqus_shortname = 'wapics';
    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);

    $('[data-toggle=\"tooltip\"]').tooltip()

    $(document).on('click', '.share-link', function(ev){
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(document).find('.image-view_share').fadeOut(600);
            $('html, body').animate({ scrollTop: 0 });
        }
        else {
            $(this).addClass('active');
            $(document).find('.image-view_share').fadeIn(600);
            $('html, body').animate({ scrollTop: $(document).height()-$(window).height() });
        }
    });

    $(document).on('click', '.like-link', function(ev){
        ev.preventDefault();
        var link = $(this);
        $.ajax({
            url: '".Url::toRoute(['like', 'link' => $link])."',
            dataType: 'json'
        })
        .done(function( response ) {
            $(link).find('span').text(response.likes);
            if (response.action == 'like')
                $(link).addClass('active');
            else
                $(link).removeClass('active');
        });
    });

    var client = new ZeroClipboard( document.getElementsByClassName('copy-button') );

    client.on( 'ready', function( readyEvent ) {
        client.on( 'copy', function (event) {
            var clipboard = event.clipboardData;
            var data = $(event.target).parent().prev().find('input').val();
            clipboard.setData( 'text/plain', data );
        });

        client.on( 'aftercopy', function( event ) {
            $.notify('Ссылка скопирована в буфер обмена', 'success');
        });
    });
", \yii\web\View::POS_READY);
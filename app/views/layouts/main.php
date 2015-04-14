<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        $items = [
            ['label' => 'Галерея', 'url' => ['/site/gallery']],
            ['label' => 'Информация', 'url' => ['/site/information']],
            ['label' => 'Обратная связь', 'url' => ['/site/contacts']],
            ['label' => 'Войти', 'url' => ['/site/login'], 'linkOptions' => ['class' => 'modalWindow']]
        ];
    } else {
        $items = [
            ['label' => 'Галерея', 'url' => ['/site/gallery']],
            ['label' => 'Мои изображения', 'url' => ['/site/my-images']],
            ['label' => 'Информация', 'url' => ['/site/information']],
            ['label' => 'Обратная связь', 'url' => ['/site/contacts']],
            ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) : ?>
            <div class="alert alert-<?= $key ?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <?= $message ?>
            </div>
        <?php endforeach; ?>
        <?= $content ?>
    </div>
</div>

<div class="modal fade" data-backdrop="static" tabindex="-1"></div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; WAPICS.RU <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

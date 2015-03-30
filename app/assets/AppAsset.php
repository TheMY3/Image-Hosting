<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/media';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/fileinput.css',
    ];
    public $js = [
        'js/fileinput.js',
        'js/fileinput_locale_ru.js',
        'js/share42/share42.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

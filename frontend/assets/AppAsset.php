<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/common.css',
        'css/dsj.css',
        'css/other.css',
        'css/user.css',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $js = [
        'js/coke.js',
        'js/idangerous.swiper-2.1.min.js',
        'js/jquery.1.8.0.min.js',
        'js/jquery.cookie.js',
        'js/js.js',
        'js/RefreshCarCount.js',
        'js/vali_form.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/common.css',
        'css/dsj.css',
        'css/other.css',
        'css/user.css',
        'css/userinfo.css',
        'css/bootstrap.min.css',
        'css/bootstrap-theme.min.css',
    ];
    public $js = [
        'js/coke.js',
        'js/idangerous.swiper-2.1.min.js',
        'js/bootstrap.min.js',
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

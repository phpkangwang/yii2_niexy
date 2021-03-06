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
	'css/main.css',
        'css/common.css',
        'css/other.css',
        'css/bootstrap.min.css',
        'css/bootstrap-theme.min.css',
    ];
    public $js = [
	'js/main.js',
        'js/coke.js',
        'js/idangerous.swiper-2.1.min.js',
        'js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta http-equiv="pragma" content="no-cache" />
    <script charset="utf-8"  type="text/javascript" src="js/jquery.1.8.0.min.js"></script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>




<div class="bottommenu">
    <a href="<?= Yii::$app->urlManager->createUrl('site/index')?>" class="top1"><img src="images/top1.png" /><em>首页</em></a>
    <a href="" class="top2"><img src="images/top4.png" /><em>我要吃饭</em></a>
    <a href="<?= Yii::$app->urlManager->createUrl('car/index')?>" class="top3"><img src="images/top3.png" /><em>购物车</em></a>
    <a href="<?= Yii::$app->urlManager->createUrl('user/index')?>" class="top4"><img src="images/top2.png" /><em>会员中心</em></a>
</div>
<?= Alert::widget() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

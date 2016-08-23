<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>后台管理</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '后台管理',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '管理首页', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '登陆', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => '登出 (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="containers main-layout">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget(['options' => ['class' => 'backend-alert']]) ?>
        <div class="row">
          <?php if(!Yii::$app->user->isGuest) { ?>
          <div class=" sidebar">
            <ul class="nav nav-sidebar">
              <li><a href="<?= Url::to(['user/index']) ?>">用户管理</a></li>
              <li><a href="<?= Url::to(['goods/index']) ?>">商品管理</a></li>
              <li><a href="">拾香得味</a></li>
              <li><a href="">拾香得味</a></li>
              <li><a href="">拾香得味</a></li>
              <li><a href="">拾香得味</a></li>
              <li><a href="">拾香得味</a></li>
            </ul>
            <div class="footer">
              <p class="pull-left">&copy; 驿渡网 <?= date('Y') ?>
                <span class="glyphicon glyphicon-heart" style="color:#FF3B30;"></span>
              </p>
            </div>
          </div>
          <?php } ?>
          <div class=" main position-sty">
            <?= $content ?>
          </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
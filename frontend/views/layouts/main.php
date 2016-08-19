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
<div class="moveleft">
 <div class="mlwarp">
	<i class="mlgomr"></i>
 </div>
 <!-- header -->
	
 <div id="header">
  
    <div class="hewarp">
		<ul>
			<li class="index">
				<a href="<?= Yii::$app->urlManager->createUrl('site/index')?>" title="店铺首页" >
				<img src="images/top1.png" alt=""/>
				 首 页
				</a>
			</li>
            
            	<li class="history">
			<a href="show/list.asp" title="产品列表">
				<img src="images/top4.png" alt=""/>
				我要吃饭 
			  </a>
			</li>
			
            
			<li class="narcar">
			  <a href="<?= Yii::$app->urlManager->createUrl('car/index')?>"  title="我的购物车" >
				<img src="images/top3.png" alt=""/>
				购物车
			 
			  <span class="count">0</span>  <!-- 加入购物车的数量 --> </a>
			</li>
		
            
            <li>
			<a href="<?= Yii::$app->urlManager->createUrl('user/index')?>"  title="会员中心">  
				<img src="images/top2.png" alt=""/>
				会员中心
			  </a>
			</li>
            
		   <li class="classify">
			<span>
 <a href="javascript:void(0);" onclick="show();">
				<img src="images/top5.png" alt="">
				更多分类</a>
			</span> 
			</li>
		</ul>
	</div>
  
 </div>


<?= Alert::widget() ?>
<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<link href="<?= Yii::getAlias('@cdnUrl')?>/css/goodsinfo.css" rel="stylesheet" type="text/css" />
<div class="main">
<div class="food-img">
<img src="<?= Yii::getAlias('@cdnUrl').$info['b_image']?>" alt="食物图片">
</div>
<div class="food-name">
<p><?= $info['name']?></p>
<div class="xiaos">月售<span><?= $info['sell_num']?></span>份</div>
<div class="jiag-div">
<div class="jiag">￥<span><?= $info['price']?></span></div>
<div class="join-btn"><input type="button" value="加入购物车"></div>
</div>
</div>

<div class="food-info">
<p class="title-p">商品简介</p>
<div class="about-this"><?= $info['description']?></div>
</div>

<div class="evaluate">
<p class="title-p">商品评价</p>
<ul class="evaluate-list">
<li>
<div class="time-div">2016-08-24 12:33</div>
<div class="user-name">张小凡</div>
<div class="evaluate-detil">
<div class="dianzan">11</div>
<div class="xianqi">建议采用结构式文摘...</div>
</div>
</li>
<li>
<div class="time-div">2016-08-24 12:33</div>
<div class="user-name">hahahhaha</div>
<div class="evaluate-detil">
<div class="dianzan">11</div>
<div class="xianqi">为了使JBCAS中的英文标题和摘要书文摘要与CA收录文摘进行题和摘要中存在的问题,建议采用结构式文摘...</div>
</div>
</li>
</ul>
</div>

</div>

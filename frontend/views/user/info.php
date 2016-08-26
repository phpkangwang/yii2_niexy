<?php
   $this->title = "个人中心"; 
?>
<div class="frame">
  <div class="weixin-frame">
    <div class="weixin-toux">
        <div class="toux"><img src="<?php if($user['imgurl'] == ""){echo $user['wx_imgurl'];}else{  }?>"/></div>
        <div class="toux-name">
          <p class="name-h">王康</p>
        </div>
        <div class="arrow"><div class="arrow-down"></div></div>
    </div>
  </div>
  <div class="clear-up3"></div>
  <div class="weixin-list">
      <div class="list"><img src="<?= Yii::getAlias('@cdnUrl')?>/images/icon/fukuan.png"/></div>
      <div class="list-name">
        <p class="name-h">待付款</p>
      </div>
      <div class="list-arrow"><div class="arrow-down"></div></div>
  </div>
  <div class="weixin-list2">
      <div class="list"><img src="<?= Yii::getAlias('@cdnUrl')?>/images/icon/fahuo.png"/></div>
      <div class="list-name">
        <p class="name-h">待发货</p>
      </div>
      <div class="list-arrow"><div class="arrow-down"></div></div>
  </div>
  <div class="weixin-list">
      <div class="list"><img src="<?= Yii::getAlias('@cdnUrl')?>/images/icon/shouhuo.png"/></div>
      <div class="list-name">
        <p class="name-h">待收货</p>
      </div>
      <div class="list-arrow"><div class="arrow-down"></div></div>
  </div>
  <div class="weixin-list2">
      <div class="list"><img src="<?= Yii::getAlias('@cdnUrl')?>/images/icon/pingjia.png"/></div>
      <div class="list-name">
        <p class="name-h">待评价</p>
      </div>
      <div class="list-arrow"><div class="arrow-down"></div></div>
  </div>
  <div class="weixin-list">
      <div class="list"><img src="<?= Yii::getAlias('@cdnUrl')?>/images/icon/tuikuan.png"/></div>
      <div class="list-name">
        <p class="name-h">退款中</p>
      </div>
      <div class="list-arrow"><div class="arrow-down"></div></div>
  </div>
</div>

<div class="clear-up3"></div>
<div class="weixin-list" onclick="document.location='<?= Yii::$app->urlManager->createUrl('user/bind-phone')?>'">
    <div class="list"><img src="<?= Yii::getAlias('@cdnUrl')?>/images/icon/bdshouji.png"/></div>
    <div class="list-name">
      <p class="name-h" style="display: <?php if($user->phone ==""){echo "block";}else{echo "none";}?>">绑定手机</p>
      <p class="name-h" style="display: <?php if($user->phone !=""){echo "block";}else{echo "none";}?>">已绑定  (<span class="phone-num"><?= $user->phone?></span>)</p>
    </div>
    <div class="list-arrow"><div class="arrow-down"></div></div>
</div>

<div class="clear-up3"></div>
<div class="weixin-list">
    <div class="list"><img src="<?= Yii::getAlias('@cdnUrl')?>/images/icon/kajuan.png"/></div>
    <div class="list-name">
      <p class="name-h">我的卡卷</p>
    </div>
    <div class="list-arrow"><div class="arrow-down"></div></div>
</div>
<div class="weixin-list2">
    <div class="list"><img src="<?= Yii::getAlias('@cdnUrl')?>/images/icon/jifen.png"/></div>
    <div class="list-name">
      <p class="name-h">我的积分</p>
    </div>
    <div class="list-arrow"><div class="arrow-down"></div></div>
</div>
<div class="weixin-list" onclick="document.location='<?= Yii::$app->urlManager->createUrl('user/address')?>'">
    <div class="list"><img src="<?= Yii::getAlias('@cdnUrl')?>/images/icon/dizhi.png"/></div>
    <div class="list-name">
      <p class="name-h" style="display: <?php if($user->address ==""){echo "block";}else{echo "none";}?>">我的地址</p>
      <p class="name-h" style="display: <?php if($user->address !=""){echo "block";}else{echo "none";}?>">我的地址 (<span class="phone-num"><?= mb_substr($user->address, 0,15,'utf-8')?></span>)</p>
    </div>
    <div class="list-arrow"><div class="arrow-down"></div></div>
</div>
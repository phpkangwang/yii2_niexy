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
      <div class="list"><img src=""/></div>
      <div class="list-name">
        <p class="name-h">待付款</p>
      </div>
      <div class="list-arrow"><div class="arrow-down"></div></div>
  </div>
  <div class="weixin-list2">
      <div class="list"><img src=""/></div>
      <div class="list-name">
        <p class="name-h">待发货</p>
      </div>
      <div class="list-arrow"><div class="arrow-down"></div></div>
  </div>
  <div class="weixin-list">
      <div class="list"><img src=""/></div>
      <div class="list-name">
        <p class="name-h">待收货</p>
      </div>
      <div class="list-arrow"><div class="arrow-down"></div></div>
  </div>
  <div class="weixin-list2">
      <div class="list"><img src=""/></div>
      <div class="list-name">
        <p class="name-h">待评价</p>
      </div>
      <div class="list-arrow"><div class="arrow-down"></div></div>
  </div>
  <div class="weixin-list">
      <div class="list"><img src=""/></div>
      <div class="list-name">
        <p class="name-h">退款中</p>
      </div>
      <div class="list-arrow"><div class="arrow-down"></div></div>
  </div>
</div>

<div class="clear-up3"></div>
<div class="weixin-list">
    <div class="list"><img src=""/></div>
    <div class="list-name">
      <p class="name-h">绑定手机</p>
    </div>
    <div class="list-arrow"><div class="arrow-down"></div></div>
</div>

<div class="clear-up3"></div>
<div class="weixin-list">
    <div class="list"><img src=""/></div>
    <div class="list-name">
      <p class="name-h">我的卡卷</p>
    </div>
    <div class="list-arrow"><div class="arrow-down"></div></div>
</div>
<div class="weixin-list2">
    <div class="list"><img src=""/></div>
    <div class="list-name">
      <p class="name-h">我的积分</p>
    </div>
    <div class="list-arrow"><div class="arrow-down"></div></div>
</div>
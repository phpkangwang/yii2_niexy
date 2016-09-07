<?php
   $this->title = "我的订单";
?>
<div class="frame">
  <div class="sale-frame">
  
       <?php if($allOrder != ""){
           foreach ($allOrder as $val){
       ?>
         <div class="sale-toux">
            <p class="order-name-h order-title">拾香得味 ></p>
            <div class="order-position">
                <div class="order-content">
                  <?php foreach ($val['content'] as $content){?>
                  <p><?= $content['name']?></p>
                  <?php }?>
                </div>
                
                <div class="order-price">
                  <?php foreach ($val['content'] as $content){?>
                  <p>x <?= $content['num']?></p>
                  <?php }?>
                </div>
                <div class="order-sumprice">
                                         共<span>8</span>份
                <strong>总价格:<span id="money"><?= $val['pay_price']/100?></span>元</strong>
                </div>
            </div>
            
            <a class="fixed-a order-button" href="<?= Yii::getAlias('@cdnUrl')."/wxpay/demo/js_api_call.php?openid=".Yii::$app->user->identity->login_type_id."&money=".$val['pay_price']."&orderId=".$val['id']?>">结算</a>
         </div>
         <?php }}?>
         
            
         </div>
    </div>
</div>

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
            </div>
            <div class="order-sumprice">总价格:<span><?= $val['pay_price']?></span>元</div>
            <a class="fixed-a order-button">结算</a>
         </div>
         <?php }}?>
         
            
         </div>
    </div>
</div>
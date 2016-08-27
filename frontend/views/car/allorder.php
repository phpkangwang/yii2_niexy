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
                <strong>总价格:<span>20</span>元</strong>
                </div>
            </div>
            
            <a class="fixed-a order-button">结算</a>
         </div>
         <?php }}?>
         
            
         </div>
    </div>
</div>
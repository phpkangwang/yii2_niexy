<?php
   $this->title = "个人中心"; 
?>
<div class="userinfo-top">
    
   <div class="userinfo-head"><img src="images/1.jpg" /></div>
   
   <div class="userinfo-mobile" onclick="alert(22)"> 绑定手机号</div>
    
</div>
<div class="userinfo-ordermenu userinfo-ordermenu1">
    
    
     <div class="orderMsg">
         <a class="myorder">我的订单</a>
     </div>
    
</div>
<div class="userinfo-ordermenu userinfo-ordermenu2">
     <div class="orderMsg">
         <a class="myorder">我的订单</a>
     </div>
     <div class="orderMsg">
         <a class="myorder">我的订单</a>
     </div>
    
</div>
<div class="userinfo-ordermenu userinfo-ordermenu3">
     <div class="orderMsg">
         <a class="myorder">我的订单</a>
     </div>
     <div class="orderMsg">
         <a class="myorder">我的订单</a>
     </div>
     <div class="orderMsg">
         <a class="myorder">我的订单</a>
     </div>
   
</div>



<script>
 $(function(){
       var height=$(window).height();
       $(".userinfo-top").height(height/8);
  });
</script>


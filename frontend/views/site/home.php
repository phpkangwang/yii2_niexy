<?php
/* @var $this yii\web\View */

$this->title = yii::$app->params['WEB_TITLE'];
?>


</head>
<body>

<!-- header END -->
<!-- banner -->
<div class="bgstyle banner">
   <div class="swiper-container bannerswiper">
<div class="swiper-wrapper">
       <div class="swiper-slide bawarp"> <img  src="uploadfile/1.jpg" alt='1' /></div> 
         
         <!--    
        <div class="swiper-slide bawarp"> <img  src="uploadfile/2.jpg" alt='2' /></div> 
            
        <div class="swiper-slide bawarp"> <img  src="uploadfile/3.jpg" alt='3' /></div> 
            
        <div class="swiper-slide bawarp"> <img  src="uploadfile/4.jpg" alt='4' /></div> 
         -->
</div>
	  <div class="pagination"></div>
    </div>
</div>
<!-- banner END -->



<div class="clearfix moreshop martop15">

             <div class="bgstyle clearfix merchant" style="display:none">
	                <a href="index.asp@wxa76_" > 
	              <div class="merchantlogo fl">
			           
                          <img src="images/images111.jpg" alt="商家logo"/><!-- 商户LOGO -->
                           
		          </div>
			 <div class="userinfo">
				    <strong>免费前后台测试店铺 </strong>
			   	  <span>
					<em><font>欢迎光临：</font>点击一下即可切换至本店</em>
					<em><font>功能按钮</font>在下面彩色方格^-^</em>
				 </span>
			 </div>
		 </a>	
	   </div>
	              
            
</div>    
 
 
 
 
 
<!-- 栏目
<div class="bgstyle indexsub">
	 <ul>
     
		<li class="s1 bg1"><a href="show/list.asp@58__adfezg.php">
			<div class="subtype">
				<em> 我要吃饭 </em>
				<span>点此浏览菜谱</span>
				<s></s>
			</div></a>
		</li>
        
           
		<li class="s2 bg2" style="display:none"><a href="myorder/default.htm">
		   <div class="subtype">
			   <em>消费记录</em>
				<span>详细介绍</span>
				<s></s>
		   </div></a>
		</li>
    
 
		<li class="s3 bg3"><a href="myorder/default.htm"> 
		    <div class="subtype">
				<em>我的订单</em>
				<span>消费明白</span>
				<s></s>
			</div></a>
		</li>
        
          
		<li class="s4 bg4"><a href="../api.map.baidu.com/geocoder@address=_25C4_25CF_25BE_25A9_25CA_25D0_25D6_25E9_25BD_25AD_25C2_25B788_25BA_25C5&output=html&src=yourCompanyName_7CyourAppName"> 
		     <div class="subtype">
				<em>地图指引</em>
				<span>百度地图</span>
				<s></s>
			</div></a>
		</li>
   
     
		<li class="s2 bg5" style="display:none"><a href="show/lyb.asp"> 
			<div class="subtype">
				<em>七嘴八舌</em>
				<span>聊聊谈谈</span>
				<s></s>
			</div></a>
		</li>
		<li class="s3 bg6"><a href="user/about.asp@id=1"> 
		   <div class="subtype">
			   <em>关于我们</em>
				<span>放心消费</span>
				<s></s>
		   </div></a>
		</li>
	 </ul>
</div>
 栏目 END -->

<!-- 热门商品 -->
<div class="indexhot">
	 <div class="titlestyle">
		<strong>热门商品</strong><span class="fr" style="color:#666;font-weight:normal;">（可左右两边划动）</span>
	 </div>
 
	 <div class="indexgoodslist clearfix">
	 
	 
	    <div class="hotswiper">
			
			 <ul class="swiper-wrapper"> 
              <?php if(!empty($show)){
                  foreach ($show as $val){
              ?>
              <li class="swiper-slide bgstyle">
					<a href="<?= yii::$app->urlManager->createUrl('goods/info')."&id=".$val['id']?>"> 
					<span class="pic"><img src="<?= Yii::getAlias('@cdnUrl').$val['s_image']?>" alt="点击查看详情"  height="80px" width="100px"/></span>
					<span class="name"><?= $val['name']?> </span>
                    <span class="name"><em>单价：</em><font color="#00CC33"><?= $val['price']?></font>元</span>
					</a>
				</li>  
              <?php 
                  }//end foreach
                  }//end if?>    
 
			 </ul>
			
       </div>	
	 </div>
</div>
<!-- 热门商品 END -->

<div class="indexhot">
	 <div class="titlestyle">
		<strong>每日推荐</strong><span class="fr" style="color:#666;font-weight:normal;"></span>
	 </div>
 
	 <div class="indexgoodslist clearfix">
	    <div class="hotswiper">
			 <ul class="swiper-wrapper"> 
              <?php if(!empty($show)){
                  foreach ($show as $val){
              ?>
              <li class="swiper-slide bgstyle">
					<a href="<?= yii::$app->urlManager->createUrl('goods/info')."&id=".$val['id']?>"> 
					<span class="pic"><img src="<?= Yii::getAlias('@cdnUrl').$val['s_image']?>" alt="点击查看详情"  height="80px" width="100px"/></span>
					<span class="name"><?= $val['name']?> </span>
                    <span class="name"><em>单价：</em><font color="#00CC33"><?= $val['price']?></font>元</span>
					</a>
				</li>  
              <?php 
                  break;}//end foreach
                  }//end if?>    
 
			 </ul>
			
       </div>	
	 </div>
</div>


</div>

<script>
  var mySwiper = new Swiper('.swiper-container',{
    pagination: '.pagination',
    loop:true,
    grabCursor: true,
    paginationClickable: true,
	autoplay: 5000
  });
  var mySwiper = new Swiper('.hotswiper',{
	paginationClickable: true,
    slidesPerView: 'auto'
  });
  </script>




<script type="text/javascript"> 
var EX = {
  addEvent:function(k,v){
    var me = this;
    if (me.addEventListener)
      me.addEventListener(k, v, false);
    else if(me.attachEvent)
      me.attachEvent("on" + k, v);
    else
      me["on" + k] = v;
  },
  removeEvent:function(k,v){
    var me = this;
    if (me.removeEventListener)
      me.removeEventListener(k, v, false);
    else if (me.detachEvent)
      me.detachEvent("on" + k, v);
    else
      me["on" + k] = null;
  },
  stop:function(evt){
    evt = evt || window.event;
    evt.stopPropagation?evt.stopPropagation():evt.cancelBubble=true;
  }
};
document.getElementById('pop').onclick = EX.stop;
var url = '#'; 
function show(){ 
var o = document.getElementById('pop'); 
o.style.display = ""; 
setTimeout(function(){EX.addEvent.call(document,'click',hide);});
} 
function hide(){ 
var o = document.getElementById('pop'); 
o.style.display = "none"; 
EX.removeEvent.call(document,'click',hide);
} 
</script>







</body>
</html>

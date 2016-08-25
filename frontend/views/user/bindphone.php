<?php
$this->title = "手机绑定";
?>
<div class="frame">
  <div class="input-frame">
    <div class="input-tel">
      <div class="input-qh">+86 <span class="">V</span></div>
      <div class="input-txt"><input type="number" placeholder="请输入手机号码" id="phone" name="phone" value="<?= $user->phone?>" maxlength="11"/></div>
      <a class="input-a" onclick="sendSms()">获取验证码</a>
    </div>
    <div class="input-yzm">
      <div class="input-yzm-t">验证码</div>
      <div class="input-yzm-i"><input type="text" placeholder="请输入验证码" id="smsyzm" name="smsyzm" maxlength="6"/></div>
    </div>
  </div>
  <div class="box">
    <a class="login-a up3">确定</a>
  </div>
</div>
<script>
   var wait=60;
   function sendSms()
   {
	   //检查手机号是否合法
       var phone = $("#phone").val().trim();
	   var reg= /^1[0-9]{10}$/;
	   if(phone == "" || !reg.test(phone))
	   {
		  alert("请输入正确的手机号码");
		  return false;
	   }
	    
	    var yzmName = $(".input-a").text();
	    if(yzmName == "获取验证码")
	    {
		    //发送验证码
	    	var data = {};
	    	data.phone = phone;
	    	data._frontend = '<?php echo Yii::$app->request->getCsrfToken() ?>';
	    	$.ajax({
	    	  type: 'post',
	    	  dataType: 'json',
	    	  url: '<?= Yii::$app->urlManager->createUrl('site/send-sms') ?>',
	    	  data: data,
	    	  async:false,
	    	  success: function(res) {
	    		  if(res.code == -1){
	    			  alert(res.message);
	    			  return;
	    		  }else{
		    		  alert("短信发送成功,请耐心等候");
		    	  }
	    	  }
	    	});
		    
		    //开始倒计时
	    	$(".input-a").text("重新发送(" + wait + ")");
	    	setTimeout(function() {
	         	   time(wait);
		            },10);
		}
   }

   function time(t){
	   if(t == 0)
	   {
			$(".input-a").text("获取验证码");
			t = 10;
	   }
	   else
	   {
		   $(".input-a").text("重新发送(" + t + ")");
           t--;
           setTimeout(function() {
        	   time(t);
	            },1000);
	   }
   }

   $(".login-a").click(function(){
	    var phone = $("#phone").val().trim();
	    var smsyzm = $("#smsyzm").val().trim();
		 //发送验证码
	   	var data = {};
	   	data.phone = phone;
	   	data.smsyzm = smsyzm;
	   	data._frontend = '<?php echo Yii::$app->request->getCsrfToken() ?>';
	   	$.ajax({
	   	  type: 'post',
	   	  dataType: 'json',
	   	  url: '<?= Yii::$app->urlManager->createUrl('site/check-sms') ?>',
	   	  data: data,
	   	  async:false,
	   	  success: function(res) {
	   		  if(res.code == -1){
	   			  alert(res.message);
	   			  return;
	   		  }else{
		   		  alert("绑定成功");
	   			  window.location='<?= Yii::$app->urlManager->createUrl('user/info')?>'
		      }
	   	  }
	   	});
   });

</script>
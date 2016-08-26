<?php
   $this->title = "修改地址"; 
?>
<div class="frame">
  <div class="input-frame">
            <div class="input-yzm">
              <div class="input-yzm-t">地址：</div>
              <div class="input-yzm-i"><input type="text" placeholder="请输入收货地址" id="address" value="<?= $user->address?>" maxlength="50"/></div>
            </div>
            <div class="box">
  </div>
  </div>
  <a class="login-a up3">确定</a>
</div>

<script type="text/javascript">
$(".login-a").click(function(){
	var data = {};
	data.address = $("#address").val();
	data._frontend = '<?php echo Yii::$app->request->getCsrfToken() ?>';
	$.ajax({
	  type: 'post',
	  dataType: 'json',
	  url: '<?= Yii::$app->urlManager->createUrl('user/address') ?>',
	  data: data,
	  async:false,
	  success: function(res) {
		  if(res.code == -1){
			  alert("修改失败,请联系管理员");
		  }
		  window.location='<?= Yii::$app->urlManager->createUrl('user/info')?>'
	  }
	});
});


</script>
  
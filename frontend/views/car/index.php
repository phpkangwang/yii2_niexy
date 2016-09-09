<?php
   $this->title = "购物车";
?>
<!--
 *@购物车
-->
<div class="frame">
  <div class="sale-frame">
    <div class="sale-titel">
      <div class="sale-qh"><img src="<?= Yii::getAlias('@cdnUrl')?>/images/icon/gouwuche.png"/></div>
      <div class="sale-txt"><p>拾香得味<span class="sale-span">></span></p></div>
    </div>
        <?php
        if($myGoods != ""){ 
        foreach ($myGoods as $val){?>
         <div class="sale-toux" id="tou<?= $val['info']['id']?>">
            <div class="sale-name">
              <p class="sale-name-h"><?= $val['info']['name']?></p>
              <p class="sale-name-fl"><?= mb_substr($val['info']['description'], 0,15,'utf-8')?></p>
              <p class="sale-price">￥ <i class="show-price"><?= $val['info']['price']?></i>
                		   <span class="lgadd fr">
                             <button type=button class='lgminus' data-id='<?= $val['info']['id']?>'>   -   </button>
                             <input type=text value="<?= $val['num']?>" id="numb" name='numb' size='2' class="addtext" maxlength='3' dataType='Number' msg='必须为数字' readonly="readonly">
                             <button type=button class='lgplus'  data-id='<?= $val['info']['id']?>'>   +   </button>
                             <div class="car_item_piao">+1</div>
                            </span>
               </p>
             </div>
            	   
              
        </div>
        <?php }
        }
        ?>

    </div>

</div>


<div class="fixed-frame">
  <div class="fixed-box">
    <div class="fixed-titel">
      <div class="fixed-txt"><p><span class="fixed-span">合计：<span class="span-jg"><span id="sumPrice">0</span> 元 <span class="span-yf"></span></span></span></p></div>
      <a class="fixed-a">结算(<span  id="sumNum">0</span>)</a>
    </div>
  </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
    	 getPrice();
    });
  //计算所有的价格
  function getPrice()
  {
	   var sumMoney = 0;
	   var sumNum = 0;
	   $(".sale-toux").each(function(){
		  sumMoney += parseInt($(this).find(".show-price").text()) * parseInt($(this).find("#numb").val());
		  sumNum += parseInt($(this).find("#numb").val());
	   });
	   $("#sumPrice").text(sumMoney);
	   $("#sumNum").text(sumNum);
  }
  

  $(".fixed-a").click(function(){
	    var phone = "<?= yii::$app->user->identity->phone?>";
	    var add = "<?= yii::$app->user->identity->address?>";
	    if(phone == "" || add == "")
	    {
	    	alert("请先在个人中心绑定手机号和地址才能下订单");
		    return false; 
		}
	    var ids = [];
	    var nums = [];
	    $(".sale-toux").each(function(){
	    	ids.push($(this).find(".lgminus").data("id"));
	    	nums.push($(this).find("#numb").val());
	    });
	    if(ids.length == 0)
	    {
		    alert("请至少选择一种商品才能结算");
		    return false;
		}
	    
		var data = {};
		data.ids = ids;
		data.nums = nums;
	    data._frontend = '<?php echo Yii::$app->request->getCsrfToken() ?>';
	    $.ajax({
	      type: 'post',
	      dataType: 'json',
	      url: '<?= Yii::$app->urlManager->createUrl('car/create-order') ?>',
	      data: data,
	      async:false,
	      success: function(res) {
	          if(res.code == 1)
	          {
	        	  window.location = "<?= Yii::$app->urlManager->createUrl('car/jump-pay').'&id='?>"+res.data;
	        	  return;
	          }else{
		          alert("结算失败请重试");
		          return;
		      }
	      }
	    });
  });

//数量加一
  $(document).on('click','.lgplus',function(){
      var id = $(this).data("id");
  	  var data = {};
  	  var r = false;
      data.id = id;
      data._frontend = '<?php echo Yii::$app->request->getCsrfToken() ?>';
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: '<?= Yii::$app->urlManager->createUrl('car/add-car-goods') ?>',
        data: data,
        async:false,
        success: function(res) {
            if(res.code == 1)
            {
          	  r = true;
            }
        }
      });
      if(r)
      {
      	var num = parseInt($(this).siblings('#numb').val())+1;
      	$(this).siblings("#numb").val(num);
      	var redpoint_car = parseInt($("#redpoint_car").text());
      	$("#redpoint_car").text(redpoint_car+1);
      	$("#redpoint_car").show();
      	getPrice();
      }
  });

  //数量减一
  $(document).on('click','.lgminus',function(){
  	var num = parseInt($(this).siblings('#numb').val());
  	if(num > 0){
  		var id = $(this).data("id");
  		var r = false;
      	var data = {};
          data.id = id;
          data._frontend = '<?php echo Yii::$app->request->getCsrfToken() ?>';
          $.ajax({
            type: 'post',
            dataType: 'json',
            url: '<?= Yii::$app->urlManager->createUrl('car/sub-car-goods') ?>',
            data: data,
            async:false,
            success: function(res) {
          	  if(res.code == 1)
                {
              	  r = true;
                }
            }
          });
          if(r)
          {
        	  $(this).siblings("#numb").val(num-1);
        	  var redpoint_car = parseInt($("#redpoint_car").text());
              $("#redpoint_car").text(redpoint_car-1);
        	  if(num-1 == 0)
        	  {
        		  $("#tou"+id).remove();
              }
              if(redpoint_car-1 == 0)
              {
            	  $("#redpoint_car").hide(); 
              }
        	  getPrice();
          }
  	}
  });
</script>

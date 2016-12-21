<?php
   $this->title = "客户下的订单";
?>
<div class="frame">
  <div class="sale-frame">
  
         
            
         </div>
    </div>
</div>
<input type="hidden" value="0" id="nowId">
<script type="text/javascript">
$(document).ready(function(){
	getOrders();
	setInterval("getOrders()",10000);

	//退单
	$(".back").click(function(){
		var word = $(this).text();
		if(word == "退款中")
		{
			return;
		}
	    var id = $(this).data("id");
		var data = {};
		var r = false;
	    data.id = id;
	    data._frontend = '<?php echo Yii::$app->request->getCsrfToken() ?>';
	    $.ajax({
	      type: 'post',
	      dataType: 'json',
	      url: '<?= Yii::$app->urlManager->createUrl('car/back-order') ?>',
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
	    	$(this).text("退款中");
	    	$(this).siblings(".accept").remove();
	    }
	    else
	    {
	        alert("退单失败");
	    }
	});

	//接单
	$(".accept").click(function(){
		var word = $(this).text();
		if(word == "已接单")
		{
			return;
		}
	    var id = $(this).data("id");
		var data = {};
		var r = false;
	    data.id = id;
	    data._frontend = '<?php echo Yii::$app->request->getCsrfToken() ?>';
	    $.ajax({
	      type: 'post',
	      dataType: 'json',
	      url: '<?= Yii::$app->urlManager->createUrl('car/accept-order') ?>',
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
	    	$(this).text("已接单");
	    }
	    else
	    {
	        alert("接单失败");
	    }
	});
});

function getOrders()
{
	var id = $("#nowId").val();
	var data = {};
    data._frontend = '<?php echo Yii::$app->request->getCsrfToken() ?>';
    data.id=id;
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '<?= Yii::$app->urlManager->createUrl('car/get-admin-order') ?>',
      data: data,
      async:false,
      success: function(res) {
    	  for(var i=res.length-1;i>=0;i--)
	        {
	   	        var html = "";
	   	        html = '<div class="sale-toux">'+
    		            '<p class="order-name-h order-title">拾香得味 ></p>'+
    		            '<div class="order-position">'+
    		                '<div class="order-content">';
                for(var j=0;j<res[i].content.length;j++)
                {
                	html += '<p>'+res[i].content[j].name+'</p>';
	            }
                html += '</div>'+
                        '<div class="order-price">';
                for(var j=0;j<res[i].content.length;j++)
                {
                	html += '<p>x'+res[i].content[j].num+'</p>';
	            }            
                html += '</div>'+
    		             '<div class="order-sumprice">'+
    		             '<strong>总价格:<span id="money">'+res[i].pay_price/100+'</span>元</strong>'+
    		             ' </div>'+
    		             '</div>'+
    		             '<p>姓名:'+res[i].userinfo.username+'</p><p>电话:'+res[i].userinfo.phone+'</p><p>地址:'+res[i].userinfo.address+'</p>';
    		    if(res[i].statu == 2)
    		    {
    		    	html += '<a class="fixed-a order-button back" data-id='+res[i].id+' >退单</a>'+
        		            '<a class="fixed-a order-button accept"  data-id='+res[i].id+' >接单</a>'+
        		            '</div>';
        		}
        		else if(res[i].statu == 3)   
        		{
        			html += '<a class="fixed-a order-button back" data-id='+res[i].id+' >退单</a>'+
		            '<a class="fixed-a order-button accept"  data-id='+res[i].id+' >已接单</a>'+
		            '</div>';
                }
        		else if(res[i].statu == 6)   
        		{
        			html += '<a class="fixed-a order-button back" data-id='+res[i].id+' >退款中</a>'+
		            '</div>';
                }
        		else if(res[i].statu == 7)   
        		{
        			html += '<a class="fixed-a order-button back" data-id='+res[i].id+' >退款成功</a>'+
		            '</div>';
                }     
    		             
	   			$(".sale-frame").prepend(html);
	        }//end for
    	  $("#nowId").val(res[0].id);
      }
    });
}

</script>

<?php

$this->title = '商品列表';
?>
<!-- 商品列表页 -->
            <div class="listgoods">
        
		<!--  <dl class="bgstyle"> 
           <input  type="hidden"  value="159"   name="spid"/>
 		  
     
          <dt>  <a href="zhengwen.html">  <img src="../image/20130904/20130904100151465146.jpg" alt=""/>  </a></dt>
         <dd>
          
		  
		       <strong><a href="index.asp@id=159"> 鱼虾水蒸蛋 </a></strong>
			   <div class="listgoodsinfo">
					<span class="pr"> ￥20<font> 消费送15积分消费送15积分消费送15积分消费送15积分消费送15积分</font> </span>
			    
               </div>
               
             
			   <div class="clearfix">
				   <span class="lgadd fr">
                     <button type=button class='lgminus'>   -   </button> 
                     <input type=text value="0" id="numb" name='numb' size='2' class="addtext" maxlength='3' dataType='Number' msg='必须为数字' readonly="readonly">
                     <button type=button class='lgplus'  >   +   </button>
                     <div class="car_item_piao">+1</div>
 				   </span>
 			   </div>
		   </dd>
           
		</dl>
		-->

 		<input type="hidden" id="nowPage" value="1"/> 
	</div>	


<!-- 商品列表页 END -->


  
<script type="text/javascript">
$(document).ready(function(){
	//设置菜单的高度为屏幕的97%
	$(".listgoods").height($(window).height() - $(".bottommenu").height());
	
	$(window).on('scroll',function(){
		  if($(window).scrollTop()>=$(document).height()-$(window).height()){
			var pageNo = parseInt($("#nowPage").val());
		    //下拉自动翻页
		    var data = {};
		    data.pageNo = pageNo+1;
		    data._frontend = '<?php echo Yii::$app->request->getCsrfToken() ?>';
		    $.ajax({
		      type: 'post',
		      dataType: 'json',
		      url: '<?= Yii::$app->urlManager->createUrl('goods/get-page-goods') ?>',
		      data: data,
		      async:false,
		      success: function(res) {
		          if(res.data.length>0)
		          {
		        	  $("#nowPage").val(data.pageNo);
		          }
		    	  for(var i=0;i<res.data.length;i++)
			        {
			   	        var html = "";
				   	     html = '<dl class="bgstyle">'+ 
				           '<input  type="hidden"  value="159"   name="spid"/>'+
				          '<dt>  <a href="<?=  yii::$app->urlManager->createUrl('goods/info')."&id="?>'+res.data[i]['id']+'">  <img src="<?= Yii::getAlias('@cdnUrl')?>'+res.data[i]['s_image']+'" alt=""/>  </a></dt>'+
				         '<dd>'+
						       '<strong><a href=""> '+res.data[i]['name']+' </a></strong>'+
							   '<div class="listgoodsinfo">'+
									'<span class="pr"> ￥'+res.data[i]['price']+'<font> '+res.data[i]['description']+'</font> </span>'+
				               '</div>'+
							   '<div class="clearfix">'+
								   '<span class="lgadd fr">'+
				                     '<button type=button class="lgminus" data-id='+res.data[i]['id']+'>   -   </button>' +
				                     '<input type=text value="'+res.data[i]['mynum']+'" id="numb" name="numb" size="2" class="addtext" maxlength="3" dataType="Number" msg="必须为数字" readonly="readonly">'+
				                     '<button type=button class="lgplus"  data-id='+res.data[i]['id']+'>   +   </button>'+
				                     '<div class="car_item_piao">+1</div>'+
				 				   '</span>'+
				 			   '</div>'+
						   '</dd>'+
						'</dl>'
			   	        
			   			$(".listgoods").append(html);
			        }//end for
		      }//end success
		    });
		  }
		});

	
	var pageNo = parseInt($("#nowPage").val());
	//ajax获取菜单列表
	var data = {};
    data.pageNo = pageNo;
    data._frontend = '<?php echo Yii::$app->request->getCsrfToken() ?>';
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '<?= Yii::$app->urlManager->createUrl('goods/get-page-goods') ?>',
      data: data,
      async:false,
      success: function(res) {
    	  for(var i=0;i<res.data.length;i++)
	        {
    		  var html = "";
		   	     html = '<dl class="bgstyle">'+ 
		          '<dt>  <a href="<?=  yii::$app->urlManager->createUrl('goods/info')."&id="?>'+res.data[i]['id']+'">  <img src="<?= Yii::getAlias('@cdnUrl')?>'+res.data[i]['s_image']+'" alt=""/>  </a></dt>'+
		         '<dd>'+
				       '<strong><a href=""> '+res.data[i]['name']+' </a></strong>'+
					   '<div class="listgoodsinfo">'+
							'<span class="pr"> ￥'+res.data[i]['price']+'<p class="list-des"> '+res.data[i]['description']+'</font> </p>'+
		               '</div>'+
					   '<div class="clearfix">'+
						   '<span class="lgadd fr">'+
		                     '<button type=button class="lgminus" data-id='+res.data[i]['id']+'>   -   </button>' +
		                     '<input type=text value="'+res.data[i]['mynum']+'" id="numb" name="numb" size="2" class="addtext" maxlength="3" dataType="Number" msg="必须为数字" readonly="readonly">'+
		                     '<button type=button class="lgplus" data-id='+res.data[i]['id']+' >   +   </button>'+
		                     '<div class="car_item_piao">+1</div>'+
		 				   '</span>'+
		 			   '</div>'+
				   '</dd>'+
				'</dl>'
	   			$(".listgoods").append(html);
	        }//end for
      }//end success
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
              if(redpoint_car-1 == 0)
              {
            	  $("#redpoint_car").hide(); 
              }
            }
    	}
    });

    
});

</script>   
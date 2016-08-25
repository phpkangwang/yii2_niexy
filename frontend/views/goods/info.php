<link href="<?= Yii::getAlias('@cdnUrl')?>/css/goodsinfo.css" rel="stylesheet" type="text/css" />
<div class="main">
<div class="food-img">
<img src="<?= Yii::getAlias('@cdnUrl').$info['b_image']?>" alt="食物图片">
</div>
<div class="food-name">
<p><?= $info['name']?></p>
<div class="xiaos">月售<span><?= $info['sell_num']?></span>份</div>
<div class="jiag-div">
<div class="jiag">￥<span><?= $info['price']?></span></div>

        <div class="clearfix">
		   <span class="lgadd fr">
             <button type=button class='lgminus' data-id='<?= $info['id']?>'>   -   </button> 
             <input type=text value="<?= $info['mynum']?>" id="numb" name='numb' size='2' class="addtext" maxlength='3' dataType='Number' msg='必须为数字' readonly="readonly">
             <button type=button class='lgplus'  data-id='<?= $info['id']?>'>   +   </button>
             <div class="car_item_piao">+1</div>
		   </span>
	   </div>
	   
</div>
</div>

<div class="food-info">
<p class="title-p">商品简介</p>
<div class="about-this"><?= $info['description']?></div>
</div>

<div class="evaluate">
<p class="title-p">商品评价</p>
<ul class="evaluate-list">
<li>
<div class="time-div">2016-08-24 12:33</div>
<div class="user-name">张小凡</div>
<div class="evaluate-detil">
<div class="dianzan">11</div>
<div class="xianqi">建议采用结构式文摘...</div>
</div>
</li>
<li>
<div class="time-div">2016-08-24 12:33</div>
<div class="user-name">hahahhaha</div>
<div class="evaluate-detil">
<div class="dianzan">11</div>
<div class="xianqi">为了使JBCAS中的英文标题和摘要书文摘要与CA收录文摘进行题和摘要中存在的问题,建议采用结构式文摘...</div>
</div>
</li>
</ul>
</div>

</div>
<script type="text/javascript">
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
        }
	}
});
</script>

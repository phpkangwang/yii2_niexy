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
      <a class="sale-a">编辑</a>
    </div>
        <?php
        if($myGoods != ""){ 
        foreach ($myGoods as $val){?>
         <div class="sale-toux">
            <div class="sale-img"><input type="checkbox" name="goods" id="checkbox<?= $val['info']['id']?>" data-id="<?= $val['info']['id']?>" data-price="<?= $val['info']['price']?>"  data-num="<?= $val['num']?>" onclick="javascript:change(this);"/><img src="<?= Yii::getAlias('@cdnUrl').$val['info']['s_image']?>"/></div>
            <div class="sale-name">
              <p class="sale-name-h"><?= $val['info']['name']?></p>
              <p class="sale-name-fl"><?= mb_substr($val['info']['description'], 0,15,'utf-8')?></p>
              <p class="sale-price">$ <?= $val['info']['price']?>
                    <span class="">
                		   <span class="lgadd fr">
                             <button type=button class='lgminus' data-id='<?= $val['info']['id']?>'>   -   </button>
                             <input type=text value="<?= $val['num']?>" id="numb" name='numb' size='2' class="addtext" maxlength='3' dataType='Number' msg='必须为数字' readonly="readonly">
                             <button type=button class='lgplus'  data-id='<?= $val['info']['id']?>'>   +   </button>
                             <div class="car_item_piao">+1</div>
                	   </div>
            	   </span>
              </p>
        </div>
        <?php }
        }
        ?>

    </div>

</div>


<div class="fixed-frame">
  <div class="fixed-box">
    <div class="fixed-titel">
      <div class="fixed-qh"><input type="checkbox" name="quanxuan"/></div>
      <div class="fixed-txt"><p>全选<span class="fixed-span">合计：<span class="span-jg"><span id="sumPrice">0</span> 元 <span class="span-yf">不含运费</span></span></span></p></div>
      <a class="fixed-a">结算(0)</a>
    </div>
  </div>
</div>


<script type="text/javascript">
  //$(".bottommenu").hide();
  function change(obj)
  {
	  var price = $(obj).data("price");
	  var num = $(obj).data("num");
	  var id = $(obj).data("id");
	  //获取总价格
	  var sumPrice = parseInt($("#sumPrice").text());
	  if($('#checkbox'+id).is(':checked')) {
		    // do something
		  sumPrice += price*num;
		}else{
			sumPrice -= price*num;
		}
	  $("#sumPrice").text(sumPrice);
  }
</script>

<?php
   $this->title = "个人中心"; 
?>
<html>
<ul>
   <li><label>头像:</label> <label><img alt="头像" src="<?= $user['headimgurl'] ?>" width="100px" height="100px"></label></li>
   <li><label>昵称:</label> <label><?= $user['username'] ?></label></li>
   <li><label>性别:</label> <label><?php  if($user['sex'] == 1){echo "男";}else if($user['sex'] == 2){echo "女";}else{echo "保密";} ?></label></li>
   <li><label>省份:</label> <label><?= $user['province'] ?></label></li>
</ul>
</html>
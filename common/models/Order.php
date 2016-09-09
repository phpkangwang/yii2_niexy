<?php
namespace  common\models;


use Yii;
use yii\db\ActiveRecord;

class Order extends ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tb_order}}';
    }
    
    //属性中文名称
    public function attributeLabels() {
        return array(
        );
    }
    
    /**
     *  创建一个未付款的订单
     * @param unknown $ids
     * @param unknown $nums
     */
    public static function createOrder($ids,$nums)
    {
        $userId = yii::$app->user->id;
        if($userId == "")
        {
            $reInfo['code'] = -1;
            $reInfo['message'] = "请先登录";
            $reInfo['data'] = "";
            return $reInfo;
        }
        $sumPrice = 0;
        $content = array();
        //循环出商品的总价格
        for ($i=0; $i<count($ids); $i++)
        {
            $goodsObj = Goods::findOne($ids[$i]);
            $sumPrice += $goodsObj->price * $nums[$i];
            array_push($content, array('goodsId'=>$ids[$i],'num'=>$nums[$i]));
        }
        $model = new Order();
        $model->user_id = $userId;
        $model->pay_price = $sumPrice*100;//数据库里面的单位是分
        $model->content = json_encode($content);
        $model->created_at = time();
        if($model->save())
        {
            $insertId = Yii::$app->db->getLastInsertID();
            //清空购物车
            Car::clealCar();
            
            $reInfo['code'] = 1;
            $reInfo['message'] = "创建订单成功";
            $reInfo['data'] = $insertId;
            return $reInfo;
        }else{
            $reInfo['code'] = -1;
            $reInfo['message'] = "创建订单失败";
            $reInfo['data'] = print_r($carObj->getErrors());
            return $reInfo;
        }
    } 
    
    //获取我所有的订单，按时间顺序排列
    public static function getAllOrder($statu)
    {
        $userId = yii::$app->user->id;
        return self::find()->where('user_id = :userId and statu=:statu',array(':userId'=>$userId,':statu'=>$statu))->orderBy('created_at desc')->asArray()->all();
    }
    
    //获取管理员订单页面按时间顺序排列
    public static function getAdminOrder($id)
    {
        //获取所有已支付订单
        $time = strtotime(date("Y-m-d",time()));
        return self::find()->where('created_at > :time and statu >=2 and id > :id',array(':time' => $time,':id'=>$id))->orderBy('created_at desc')->asArray()->all();
    }
    
    //接订单
    public static function AcceptOrder($id)
    {
        $obj = Order::findOne($id);
        $obj->statu = yii::$app->params['PAY_STATU']['NOT_SEND'];
        if($obj->save())
        {
            $reInfo['code'] = 1;
            $reInfo['message'] = "接单成功";
            $reInfo['data'] = "";
            return $reInfo;
        }else{
            $reInfo['code'] = -1;
            $reInfo['message'] = "接单失败";
            $reInfo['data'] = print_r($carObj->getErrors());
            return $reInfo;
        } 
    }
    
    //退订单
    public static function BackOrder($id)
    {
        $obj = Order::findOne($id);
        $obj->statu = yii::$app->params['PAY_STATU']['REFUNDING'];
        if($obj->save())
        {
            $reInfo['code'] = 1;
            $reInfo['message'] = "退单请求成功";
            $reInfo['data'] = "";
            return $reInfo;
        }else{
            $reInfo['code'] = -1;
            $reInfo['message'] = "退单请求失败";
            $reInfo['data'] = print_r($carObj->getErrors());
            return $reInfo;
        }
    }
    
    
    //订单支付成功，修改订单状态
    public static function orderPaySuccess($orderId)
    {
       $obj = Order::findOne($orderId);
       $obj->statu = yii::$app->params['PAY_STATU']['READY_PAY'];
       if($obj->save())
       {
           $reInfo['code'] = 1;
           $reInfo['message'] = "创建支付成功";
           $reInfo['data'] = "";
           return $reInfo;
       }else{
           $reInfo['code'] = -1;
           $reInfo['message'] = "创建支付失败";
           $reInfo['data'] = print_r($carObj->getErrors());
           return $reInfo;
       }
    }
    
    /**
     *  添加第三方支付订单的id
     */
    public static function updateOrderId($orderId,$wxOrderid)
    {
        $obj = Order::findOne($orderId);
        $obj->order_id = $wxOrderid;
        if($obj->save())
        {
            $reInfo['code'] = 1;
            $reInfo['message'] = "修改第三方支付订单的id成功";
            $reInfo['data'] = "";
            return $reInfo;
        }else{
            $reInfo['code'] = -1;
            $reInfo['message'] = "修改第三方支付订单的id失败";
            $reInfo['data'] = print_r($carObj->getErrors());
            return $reInfo;
        }
    }
}
    

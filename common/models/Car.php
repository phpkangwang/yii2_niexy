<?php
namespace  common\models;


use Yii;
use yii\db\ActiveRecord;

class Car extends ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tb_car}}';
    }
    
    //属性中文名称
    public function attributeLabels() {
        return array(
            'user_id'     =>  '用户id',
            'content'     =>  '购物车内容',
            'updated_at'  =>  '更新时间',
            'created_at'  =>  '创建时间',
        );
    }
    
    /**
     *  添加一件商品到购物车
     */
    public static function addCarGoods($goodsId)
    {
        //查找商品是否存在
        $goodsObj = Goods::findOne($goodsId);
        if($goodsObj == "")
        {
            $reInfo['code'] = -1;
            $reInfo['message'] = "商品不存在";
            $reInfo['data'] = "";
            return $reInfo;
        }
        
        $userId = yii::$app->user->id;
        //现查找用户是否有购物车
        $carObj = self::findOne(['user_id'=>$userId]);
        if(empty($carObj))
        {
            $carObj = new Car();
            $carObj->user_id = $userId;
            $carObj->content = json_encode(array(array('goodsId'=>$goodsId,'num'=>1)));
            $carObj->updated_at = time();
            $carObj->created_at = time();
        }
        else
        {
            $content = json_decode($carObj->content,true);
            $addnum = true;
            for ($i=0; $i<count($content); $i++)
            {
                if($content[$i]['goodsId'] == $goodsId)
                {
                    $content[$i]['num'] += 1;
                    $addnum = false;
                }
            }
            if($addnum){
                if($content=="")$content=array();
               array_push($content, array('goodsId'=>$goodsId,'num'=>1));
            }
            $carObj->content = json_encode($content);
            $carObj->updated_at = time();
        }
        
        if($carObj->save())
        {
            $reInfo['code'] = 1;
            $reInfo['message'] = "添加成功";
            $reInfo['data'] = "";
            return $reInfo;
        }else{
            $reInfo['code'] = -1;
            $reInfo['message'] = "添加失败";
            $reInfo['data'] = print_r($carObj->getErrors());
            return $reInfo;
        }
    }
    
    
    
    /**
     *  减去一件商品到购物车
     */
    public static function subCarGoods($goodsId)
    {
        $userId = yii::$app->user->id;
        //现查找用户是否有购物车
        $carObj = self::findOne(['user_id'=>$userId]);
        if(empty($carObj))
        {
            $reInfo['code'] = -1;
            $reInfo['message'] = "购物车不存在";
            $reInfo['data'] = "";
            return $reInfo;
            
        }
        else
        {
            $content = json_decode($carObj->content,true);
            for ($i=0; $i<count($content); $i++)
            {
                if($content[$i]['goodsId'] == $goodsId)
                {
                    $content[$i]['num'] -= 1;
                    if($content[$i]['num']<=0){
                       unset($content[$i]); 
                       sort($content);
                    }
                }
            }
            $carObj->content = json_encode($content);
            $carObj->updated_at = time();
        }
            if($carObj->save())
            {
                $reInfo['code'] = 1;
                $reInfo['message'] = "购物车减去商品数量成功";
                $reInfo['data'] = "";
                return $reInfo;
            }else{
                $reInfo['code'] = -1;
                $reInfo['message'] = "购物车减去商品数量失败";
                $reInfo['data'] = print_r($carObj->getErrors());
                return $reInfo;
            }
    }
    
    /**
     *  清空购物车
     */
    public static function clealCar()
    {
        $userId = yii::$app->user->id;
        $carObj = self::findOne(['user_id'=>$userId]);
        if($carObj->delete())
        {
            $reInfo['code'] = 1;
            $reInfo['message'] = "清空购物车成功";
            $reInfo['data'] = "";
            return $reInfo;
        }else{
            $reInfo['code'] = -1;
            $reInfo['message'] = "清空购物车失败";
            $reInfo['data'] = print_r($carObj->getErrors());
            return $reInfo;
        }
    }
    
    /**
     *   获取我所有的购物车
     */
    public static function getMyCarGoods()
    {
        $userId = yii::$app->user->id;
        $my = self::findOne(['user_id'=>$userId]);
        if($my== "" || $my->content == "")
        {
            return NULL;
        }
        else
        {
            return json_decode($my->content,true);
        }
    } 
}
    

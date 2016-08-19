<?php
namespace  common\models;


use Yii;
use yii\db\ActiveRecord;

class BaseGlobal extends ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tb_base_global}}';
    }
    
    /**
     *  添加全局变量
     * @param unknown $name
     * @param unknown $value
     * @return string
     */
    public static function addBaseGlobal($name,$value)
    {
        $obj = new BaseGlobal();
        $obj->name = $name;
        $obj->value = $value;
        $obj->update_time = time();
        if($obj->save()){
            $reInfo['code'] = 1;
            $reInfo['message'] = "";
            $reInfo['data'] = "";
            return $reInfo;
        }else {
            $reInfo['code'] = -1;
            $reInfo['message'] = "创建全局变量失败";
            $reInfo['data'] = "";
            return $reInfo;
        }
    }
    
    /**
     *  修改全局变量
     * @param unknown $name
     * @param unknown $value
     * @return string
     */
    public static function updateBaseGlobal($name,$value)
    {
        $obj = BaseGlobal::findOne(['name'=>$name]);
        $obj->value = $value;
        $obj->update_time = time();
        if($obj->save()){
            $reInfo['code'] = 1;
            $reInfo['message'] = "";
            $reInfo['data'] = "";
            return $reInfo;
        }else {
            $reInfo['code'] = -1;
            $reInfo['message'] = "修改全局变量失败";
            $reInfo['data'] = "";
            return $reInfo;
        }
    }
    
    
    /**
     *   获取wx access_token
     */
    public static function getWxAccessToken()
    {
        $appid = yii::$app->params['APP_ID'];
        $secret = yii::$app->params['APP_SECRET'];
    
        $rs = BaseGlobal::findOne(["name" => yii::$app->params['GLOBAL_WX_ACCESTOKEN_NAME'] ]);
        
        if($rs == "" || (time() - $rs['update_time']) > yii::$app->params['GLOBAL_WX_ACCESTOKEN_time'])
        {
            //加入全局变量没有 GLOBAL_WX_ACCESTOKEN_NAME 这个数据则从微信重新获取
            $getAccessToken = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
            $accessToken = tool::getCurl($getAccessToken);
            $accessToken = $accessToken['access_token'];
            //获取到新的access_token存入数据库
            //假如有数据，先删除数据
            if($rs == ""){
                self::addBaseGlobal(yii::$app->params['GLOBAL_WX_ACCESTOKEN_NAME'],$accessToken);
            }else{
                self::updateBaseGlobal(yii::$app->params['GLOBAL_WX_ACCESTOKEN_NAME'],$accessToken);
            }
            return $accessToken;
        }else{
            return $rs['value'];
        }
    }
}

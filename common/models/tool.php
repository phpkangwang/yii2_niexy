<?php
namespace  common\models;


use Yii;
use yii\base\Model;
use yii\imagine\Image;
use linslin\yii2\curl\Curl;

class tool extends Model
{
    /**
     *  curl获取网址结果
     */
    public static function getCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res,true);
    }
    
    /**
     *  获取IP
     *  return 数组
     */
    public static function getIp()
    {
        return Yii::$app->getRequest()->getUserIP();
    }
    
    
    /**
     *  单文件上传
     *  @params $thumbnail 数组，是否生成缩略图，包含width，height
     *  return 相对cdn/imatges文件路径
     */
    public static function uploadImage($name, $type, $tmpName, $size, $url)
    {
        if(!in_array($type,yii::$app->params['IMAGE_FILE']['TYPE'])){
            //上传格式不正确
            $reInfo['code'] = -1;
            $reInfo['message'] = "上传格式不正确";
            $reInfo['data'] = "";
            return $reInfo;
        }
    
        if($size > yii::$app->params['IMAGE_FILE']['MAXSIZE'])
        {
            //上传大小不正确
            $reInfo['code'] = -1;
            $reInfo['message'] = "上传大小不正确";
            $reInfo['data'] = "";
            return $reInfo;
        }
    
        $arrImageType = explode("/", $type);
        $image['site'] = Yii::getAlias('@imgcdn').$url;//文件位置
		tool::createFolders($image['site']);
        $image['name'] = date("YmdHis",time()).time().rand(10000,99999).".".$arrImageType[1];//生成随机文件名称
        $image['url']  = $image['site'].$image['name'];//文件路径
        $image['saveUrl'] = $url.$image['name'];//数据库保存的路径
        
        move_uploaded_file($tmpName,$image['url']);//上传文件
        
        $reInfo['code'] = 1;
        $reInfo['message'] = "";
        $reInfo['data']['url'] = $image['saveUrl'];
        return $reInfo;
    }

	//创建目录
    public static function createFolders($dir){
        return is_dir($dir) or (tool::createFolders(dirname($dir)) and mkdir($dir,0777));
    }
}

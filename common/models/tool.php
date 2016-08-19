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
}

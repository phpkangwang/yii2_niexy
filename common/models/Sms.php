<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 *   手机短信
 * @author Justin 2016-04-06
*/
class Sms extends ActiveRecord
{
    
    public static function tableName() {
        return '{{%tb_sms}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'code', 'created_at'], 'required'],
        ];
    }
    
    /**
     *   添加短信
     *
     * @name Type
     * @access public
     * @author Justin 2016-04-06
     * @return true or false
     * @version :1.0.0.1
     */
    public static function addSms($phone,$code,$ip)
    {
        //1,查找这个用户最后一次发送短信的时间
        $smsObj = Sms::find()->where('statu =1 and phone = :phone',array(':phone' => $phone))->one();
        if($smsObj != "" &&  time() - $smsObj->created_at <= 60)
        {
            $reInfo['code'] = -1;
            $reInfo['message'] = "短信发送频繁,请稍后再试";
            $reInfo['data'] = "";
            return $reInfo;
        }
        
        //2同一个ip在一分钟内不得连续发送两次短信
        $smsObj = Sms::find()->where('statu =1 and  ip = :ip',array(':ip' => $ip))->one();
        if($smsObj != "" &&  time() - $smsObj->created_at <= 60)
        {
            $reInfo['code'] = -1;
            $reInfo['message'] = "同一个IP一分钟只能发送一次";
            $reInfo['data'] = "";
            return $reInfo;
        }
        
        //修改所有可用的验证码状态为已过期
        Sms::updateAll(array('statu'=> 3),'phone=:phone and statu=:statu',array(':phone'=>$phone, ':statu'=>1));
        $newSms = new Sms();
        $newSms->phone = $phone;
        $newSms->code = $code;
        $newSms->ip   = $ip;
        $newSms->created_at = time();
        $newSms->save();
        
        $reInfo['code'] = 1;
        $reInfo['message'] = "";
        $reInfo['data'] = "";
        return $reInfo;
        
    }
    
    
    /**
     *   检查验证码是否正确
     *
     * @name Type
     * @access public
     * @param unknown $phone  手机号
     * @param unknown $code  验证码
     * statu '1未使用 2已使用 3已过期',
     * @author Justin 2016-04-06
     * @return true or false
     * @version :1.0.0.1
     */
    public static function checkSmsCode($phone,$code,$statu = true)
    {
        $satleTime = 30*60;//秒
        $smsObj = Sms::find()->where('phone = :phone and code = :code',array(':phone' => $phone,':code' => $code))->one();
        
        if($smsObj == "")
        {
            $reInfo['code'] = -1;
            $reInfo['message'] = "验证码不正确";
            $reInfo['data'] = "";
            return $reInfo;
        }
        else
        {
            if($smsObj->statu == 2)
            {
                $reInfo['code'] = -1;
                $reInfo['message'] = "验证码已使用";
                $reInfo['data'] = "";
                return $reInfo;
            }
            
            if(time()-$smsObj->created_at > $satleTime || $smsObj->statu == 3)
            {
                $reInfo['code'] = -1;
                $reInfo['message'] = "验证码已过期";
                $reInfo['data'] = "";
                return $reInfo;
            } 
               
            //修改验证码为已使用
            if($statu)
            {
                $smsObj->statu = 2;
                $smsObj->save();
            }
            $reInfo['code'] = 1;
            $reInfo['message'] = "";
            $reInfo['data'] = "";
            return $reInfo;
            
        }
    }
  
}

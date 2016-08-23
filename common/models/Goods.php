<?php
namespace  common\models;


use Yii;
use yii\db\ActiveRecord;

class Goods extends ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tb_goods}}';
    }
    
    //属性中文名称
    public function attributeLabels() {
        return array(
            'name'        =>  '名称',
            'b_image'     =>  '大图片',
            's_image'     =>  '小图片',
            'description' =>  '描述',
            'price'       =>  '价格',
            'created_at'  =>  '创建时间',
        );
    }
}

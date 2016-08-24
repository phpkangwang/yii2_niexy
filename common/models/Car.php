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
    

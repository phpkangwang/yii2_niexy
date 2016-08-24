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
            'index_show'  =>  '首页推荐',
            'created_at'  =>  '创建时间',
        );
    }
    
    /**
     *  获取所有的推荐商品
     */
    public static function getAllShowGoods(){
        return self::find()->where('index_show = :show',array(':show'=>yii::$app->params['GOODS_INDEX_SHOW']))->asArray()->all();    
    }
    
    /**
     *  获取某个商品的详细信息
     */
    public static function getGoodsInfo($id)
    {
        return self::find()->where('id = :id',array(':id'=>$id))->asArray()->one();
    }
    
    /**
     *  分页获取商品列表
     *  $page 当前页数
     *  $num  一页的数量
     */
    public static function getPageAllGoods($pageNo,$pageSize)
    {
        return self::find()->orderBy(['id' => SORT_DESC])->offset(($pageNo-1)*$pageSize)->limit($pageSize)->asArray()->all();
    } 
}

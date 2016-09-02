<?php
namespace  common\models;


use Yii;
use yii\db\ActiveRecord;

class Comment extends ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tb_comment}}';
    }
    
    //属性中文名称
    public function attributeLabels() {
        return array(
        );
    }
    
    /**
     *  添加商品评论
     */
    public function addComment($goodsId,$word)
    {
        $obj = new Comment();
        $obj->user_id = yii::$app->user->id;
        $obj->goods_id = $goodsId;
        $obj->word = $word;
        $obj->created_at = time();
        if($obj->save())
        {
            $reInfo['code'] = 1;
            $reInfo['message'] = "添加评论成功";
            $reInfo['data'] = "";
            return $reInfo;
        }else{
            $reInfo['code'] = -1;
            $reInfo['message'] = "添加评论失败";
            $reInfo['data'] = print_r($carObj->getErrors());
            return $reInfo;
        }
    }
    
   /**
    *  删除商品评论
    *  只有管理员才可以删除评论
    */
    public function delComment($id)
    {
        $role = Yii::$app->user->identity->role;
        if($role != yii::$app->request->params['ROLE']['admin'])
        {
            $reInfo['code'] = -1;
            $reInfo['message'] = "只有管理员才能删除评论";
            $reInfo['data'] = "";
            return $reInfo;
        }
        $obj = Comment::findOne($id);
        if($obj->delete())
        {
            $reInfo['code'] = 1;
            $reInfo['message'] = "删除评论成功";
            $reInfo['data'] = "";
            return $reInfo;
        }else{
            $reInfo['code'] = -1;
            $reInfo['message'] = "删除评论失败";
            $reInfo['data'] = print_r($carObj->getErrors());
            return $reInfo;
        }
        
    }
    
    /**
     *  获取某个商品的所有评论
     */
    public static function getGoodsComment($goodsId)
    {
       return Comment::find()->where('goods_id = :goods_id',array(":goods_id"=>$goodsId))->asArray()->orderBy('created_at DESC')->all();
    }
}

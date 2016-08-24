<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\controllers\UserController;
/* @var $this yii\web\View */

$this->title = '后台管理';
?>
<div class="actions">
  <a href="<?= Yii::$app->urlManager->createUrl('goods/create') ?>" class="btn btn-success">创建商品</a>
</div>
<h3>商品管理</h3>
<form action="<?php echo Url::to(['goods/index'])?>" method="post">
<input type="hidden" value="<?php echo Yii::$app->request->getCsrfToken() ?>" name="_backendCSRF">
<input type="text" name="id" placeholder="请输入商品ID或者名称" style="width:260px;" value="<?php echo $id?>">
<input type="submit" value="查询">
</form>

<?= GridView::widget([
  'dataProvider' => $dataProvider,
  'columns' => [
    'id',
    'name',
    [
    'attribute'=>'b_image',
    'format' => ['image',['width'=>'50','height'=>'50',]],
    'value' => function($model){
        return Yii::getAlias('@cdnUrl').$model->b_image;
    }
    ],
    [
    'attribute'=>'s_image',
    'format' => ['image',['width'=>'50','height'=>'50',]],
    'value' => function($model){
        return Yii::getAlias('@cdnUrl').$model->s_image;
    }
    ],
    'description',
    'price',
    [
    'attribute'=>'index_show',
    'value' => function($model){
        if($model->index_show == 1){
            return "不推荐";
        }else{
            return "推荐"; 
        }
    }
    ],
    ['attribute' => 'created_at', 'format' => ['date', 'php:Y-m-d H:i']],
    ['class' => 'yii\grid\ActionColumn',
    'header' => '操作',
    'template' => '{show} {update} {delete}',
    'buttons' => [
      'show' => function($url, $model) {
        return Html::a('<span class="glyphicon glyphicon-arrow-up" title="推荐"></span>',['index-show', 'id' => $model->id]);
      },
      'update' => function($url, $model) {
        return Html::a('<span class="glyphicon glyphicon-pencil" title="修改"></span>',['update', 'id' => $model->id]);
      },
      'delete' => function($url, $model){
        return Html::a('<span class="glyphicon glyphicon-ban-circle" title="删除"></span>',['delete', 'id' => $model->id], ['data-method' => 'post','data-confirm' => Yii::t('yii', '确认删除该商品?')]);
      }
      ]
    ],
  ],
  ]); ?>

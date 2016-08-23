<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\controllers\UserController;
/* @var $this yii\web\View */

$this->title = '后台管理';
?>
<h3>用户管理</h3>
<form action="<?php echo Url::to(['user/index'])?>" method="post">
<input type="hidden" value="<?php echo Yii::$app->request->getCsrfToken() ?>" name="_backendCSRF">
<input type="text" name="userId" placeholder="请输入用户ID或者用户名和手机号码" style="width:260px;" value="<?php echo $userId?>">
<input type="submit" value="查询">
</form>

<?= GridView::widget([
  'dataProvider' => $dataProvider,
  'columns' => [
    'id',
    'username',
    'phone',
    'email',
    [   'attribute' => 'role' ,
        'value' => function($model){
        $type = Yii::$app->params['ROLE'];
        return $type[$model->role];
    }],
    [   'attribute' => 'status' ,
    'value' => function($model){
        $type = Yii::$app->params['STATU_R'];
        return $type[$model->status];
    }],
    'province',
    ['attribute' => 'created_at', 'format' => ['date', 'php:Y-m-d H:i']],
    ['class' => 'yii\grid\ActionColumn',
    'header' => '操作',
    'template' => ' {update} {forbid}',
    'buttons' => [
      'update' => function($url, $model) {
        return Html::a('<span class="glyphicon glyphicon-pencil" title="修改"></span>',['update', 'id' => $model->id]);
      },
      'forbid' => function($url, $model){
        return Html::a('<span class="glyphicon glyphicon-ban-circle" title="禁止该用户"></span>',['forbid', 'id' => $model->id], ['data-method' => 'post','data-confirm' => Yii::t('yii', '确认禁止该用户?')]);
      }
      ]
    ],
  ],
  ]); ?>

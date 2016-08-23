<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */

$this->title = '后台管理';
?>
<h3>修改用户信息</h3>
<div class="user-update">
      <div class="user-form">
      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
      <div class="row">
        <div class="col-md-5">
          <?= $form->field($model, 'username') ?>
          <?= $form->field($model,'password')->passwordInput(['value' => '']) ?>
          <?= $form->field($model,'phone')?>
          <?= $form->field($model, 'role')->dropDownList(['items' => Yii::$app->params['ROLE']]) ?>
          <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
          </div>
        </div>
      </div>
      <?php ActiveForm::End() ?>
    </div>
</div>
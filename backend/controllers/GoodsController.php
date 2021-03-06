<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\Goods;
use common\models\tool;

/**
 * Goods controller
 */
class GoodsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'only' => ['logout', 'signup'],
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
      $id = trim(yii::$app->request->post('id'));
      if($id != "")
      {
          $dataProvider = new ActiveDataProvider([
              'query' => Goods::find()->where('id = :id or name =:id',array(':id' => $id)),
              'sort' => [
                    'defaultOrder' => [
                        'id' => 'ORDER_ASC',
                    ],
              ],
          ]);
      }
      else
      {
          $dataProvider = new ActiveDataProvider([
              'query' => Goods::find(),
              'sort' => [
                    'defaultOrder' => [
                        'id' => 'ORDER_ASC',
                    ],
              ],
          ]);
      }

      return $this->render('index', ['dataProvider' => $dataProvider, 'id' => $id]);
    }
    
    //创建商品
    public function actionCreate()
    {
        $model = new Goods;
        if(yii::$app->request->post()){
            $POST = yii::$app->request->post('Goods');
            $model->name        = $POST['name'];
            $model->description = $POST['description'];
            $model->price       = $POST['price'];
            $model->created_at  = time();
            if($_FILES['b_image']['type'] != "")
            {
                $name    = $_FILES['b_image']['name'];
                $type    = $_FILES['b_image']['type'];
                $tmpName = $_FILES['b_image']['tmp_name'];
                $size    = $_FILES['b_image']['size'];
                $url     = "/images/goods/";
                $rsImage = tool::uploadImage($name, $type, $tmpName, $size, $url);
                $model->b_image = $rsImage['data']['url'];
                $imagename = explode('.', $rsImage['data']['url']);
                $model->s_image = $imagename[0].'_s.'.$imagename[1];
            }
            if($model->validate()){
                $model->save();
                Yii::$app->session->setFlash('success', '创建成功');
            }else{
                Yii::$app->session->setFlash('error', '创建失败');
            }
                return $this->redirect(['index']);
            }
        return $this->render('create', ['model' => $model]);
    }
    
    //修改商品信息
    public function actionUpdate($id)
    {
      $model = Goods::findOne($id);
      if(yii::$app->request->post()){
          $POST = yii::$app->request->post('Goods');
          $model->name        = $POST['name'];
          $model->description = $POST['description'];
          $model->price       = $POST['price'];
          $model->created_at  = time();
          if($_FILES['b_image']['type'] != "")
          {
              $name    = $_FILES['b_image']['name'];
              $type    = $_FILES['b_image']['type'];
              $tmpName = $_FILES['b_image']['tmp_name'];
              $size    = $_FILES['b_image']['size'];
              $url     = "/images/goods/";
              $rsImage = tool::uploadImage($name, $type, $tmpName, $size, $url);
              $model->b_image = $rsImage['data']['url'];
              $imagename = explode('.', $rsImage['data']['url']);
              $model->s_image = $imagename[0].'_s.'.$imagename[1];
          }
          if($model->validate()){
              $model->save();
              Yii::$app->session->setFlash('success', '修改成功');
          }else{
              Yii::$app->session->setFlash('error', '修改失败');
          }
          return $this->redirect(['index']);
      }
      return $this->render('update', ['model' => $model]);
    }

    /**
     *  删除用户
     */
    public function actionDelete($id)
    {
        $model = Goods::findOne($id);
        if($model->delete()){
            Yii::$app->session->setFlash('success', '修改成功');
        }else{
            Yii::$app->session->setFlash('error', '修改失败');
        }
        return $this->redirect(['index']);
        
    }
    
    //商品首页推荐
    public function actionIndexShow($id)
    {
        $model = Goods::findOne($id);
        if($model->index_show == yii::$app->params['GOODS_INDEX_SHOW_NOT'])
        {
            //推荐变成不推荐
            $model->index_show = yii::$app->params['GOODS_INDEX_SHOW'];
        }else{
            //不推荐编程推荐
            $model->index_show = yii::$app->params['GOODS_INDEX_SHOW_NOT'];
        }
        if($model->save()){
            Yii::$app->session->setFlash('success', '推荐成功');
        }else{
            Yii::$app->session->setFlash('success', '推荐失败');
        }
        return $this->redirect(['index']);
    }

}

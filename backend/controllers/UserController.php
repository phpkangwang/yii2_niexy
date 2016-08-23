<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\AdminForm;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * Site controller
 */
class UserController extends Controller
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
      $userId = yii::$app->request->post('userId');
      $userId = trim($userId);
      if($userId != "")
      {
          $dataProvider = new ActiveDataProvider([
              'query' => User::find()->where('id = :userId or username =:userId or name = :userId or phone = :userId',array(':userId' => $userId)),
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
              'query' => User::find(),
              'sort' => [
                    'defaultOrder' => [
                        'id' => 'ORDER_ASC',
                    ],
              ],
          ]);
      }

      return $this->render('index', ['dataProvider' => $dataProvider, 'userId' => $userId]);
    }
    
    //修改用户信息
    public function actionUpdate($id)
    {
      $model = User::findOne($id);
      if(yii::$app->request->post()){
          $postData = Yii::$app->request->post('User');
          if($postData['password']){
            $model->setPassword($postData['password']);
          }
          $model->phone = $postData['phone'];
          $model->role = $postData['role'];
          $model->save();
        return $this->redirect(['index']);
      }
      return $this->render('update', ['model' => $model]);
    }

    /**
     *  禁止用户
     */
    public function actionForbid($id)
    {
        $model = User::findOne($id);
        if($model->status == yii::$app->params['STATU']['COMMON'])
        {
            $model->status = yii::$app->params['STATU']['FORBID'];
        }else{
            $model->status = yii::$app->params['STATU']['COMMON'];
        }
        if($model->save()){
            Yii::$app->session->setFlash('success', '修改成功');
        }else{
            Yii::$app->session->setFlash('success', '修改失败');
        }
        return $this->redirect(['index']);
        
    }

}

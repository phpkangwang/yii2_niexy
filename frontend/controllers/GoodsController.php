<?php
namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\base\Controller;
use yii\filters\VerbFilter;
use common\models\Goods;

/**
 * Site controller
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
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * 所有商品列表
     *
     * @return mixed
     */
	public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     *  分页获取商品列表
     */
    public function actionGetPageGoods()
    {
        $pageNo = Yii::$app->request->post('pageNo') == "" ? 1: Yii::$app->request->post('pageNo');//默认page为1
        $pageSize = 9;//默认一页显示8条
        
        $count = Goods::find()->count();
        
        $pageMaxNum = ceil($count/$pageSize);//最大页数
        $rs = Goods::getPageAllGoods($pageNo,$pageSize);
        
        $retunInfo = array('data'=>$rs,'pageMaxNum'=>$pageMaxNum,'MaxCount' => $count);
        echo json_encode($retunInfo);
        return;
    }
    
    /**
     *  显示某个商品的详细列表
     * @param unknown $id
     * @return Ambigous <string, string>
     */
    public function actionInfo()
    {
        $id = yii::$app->request->get('id');
        $info = Goods::getGoodsInfo($id);
        
        return $this->render('info',array('info'=>$info));
    }
    
    
}

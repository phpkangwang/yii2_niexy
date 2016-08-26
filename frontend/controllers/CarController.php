<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\User;
use common\models\tool;
use common\models\BaseGlobal;
use common\models\Car;
use common\models\Goods;
use common\models\Order;

/**
 * Site controller
 */
class CarController extends Controller
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
     * Displays homepage.
     *
     * @return mixed
     */
	public function actionIndex()
    {
        //获取我购物车所有的商品
        $myGoods = Car::getMyCarGoods();
        for ($i=0;$i<count($myGoods);$i++)
        {
            $myGoods[$i]['info'] = Goods::getGoodsInfo($myGoods[$i]['goodsId']);
        }
        return $this->render('index',array('myGoods'=>$myGoods));
    }
    
    /**
     *  添加购物车 一件一件商品的添加
     */
    public function actionAddCarGoods()
    {
        $goodsId = yii::$app->request->post('id');
        $rs = Car::addCarGoods($goodsId);
        echo json_encode($rs);
        return;
    }
    
    
    /**
     *  减去购物车 一件一件商品的添加
     */
    public function actionSubCarGoods()
    {
        $goodsId = yii::$app->request->post('id');
        $rs = Car::subCarGoods($goodsId);
        echo json_encode($rs);
        return;
    }
    
    /**
     *  清空购物车
     */
    public function actionClealCar()
    {
        $rs = Car::clealCar();
        echo json_encode($rs);
        return;
    }
    
    /**
     *  生成订单
     */
    public function actionCreateOrder()
    {
        $ids = yii::$app->request->post('ids');
        $nums = yii::$app->request->post('nums');
        $rs = Order::createOrder($ids, $nums);
        echo json_encode($rs);
        return;
    }
    
    /**
     *   渲染所有订单页面
     */
    public function actionAllOrder()
    {
        //获取我所有的订单
        $allOrder = Order::getAllOrder();
        for ($j=0;$j<count($allOrder);$j++)
        {
           $contents = json_decode($allOrder[$j]['content'],true);
           for($i=0;$i<count($contents);$i++)
           {
               $goodsInfo = Goods::getGoodsInfo($contents[$i]['goodsId']);
               $contents[$i]['name'] = $goodsInfo['name'];
               $contents[$i]['price'] = $goodsInfo['price'];
           }
           $allOrder[$j]['content']= $contents;
        }
        return $this->render('allOrder',array('allOrder'=>$allOrder));
    }
    
}

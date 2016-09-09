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
     *  订单支付成功
     */
    //更新付款状态
    public function actionOrderPaySuccess()
    {
        $id = yii::$app->request->get('id');
        $wxOrderid = yii::$app->request->get('wxOrderid');
        Order::updateOrderId($id, $wxOrderid);
        $rs = Order::orderPaySuccess($id);
        echo json_encode($rs);
        return;
    }
    
    /**
     *  根据订单id跳转到订单支付页面
     */
    public function actionJumpPay()
    {
        $id = yii::$app->request->get('id');
        $obj = Order::findOne($id);
        $url = Yii::getAlias('@cdnUrl')."/wxpay/demo/js_api_call.php?openid=".Yii::$app->user->identity->login_type_id."&money=".$obj->pay_price."&orderId=".$obj->id;
        tool::JumpUrl($url);
    }
    
    /**
     *  根据订单id跳转到订单退款
     */
    public function actionJumpRefund()
    {
        $id = yii::$app->request->post('id');
        $obj = Order::findOne($id);
        echo $url = Yii::getAlias('@cdnUrl')."/wxpay/demo/refund.php?out_trade_no=".$obj->order_id."&refund_fee=".$obj->pay_price;die;
        $rs = tool::getCurl($url);
    }
    
    
    /**
     *   渲染所有订单页面
     */
    public function actionAllOrder()
    {
        $statu = yii::$app->request->get('statu');
        //获取我所有的订单
        $allOrder = Order::getAllOrder($statu);
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
        return $this->render('allorder',array('allOrder'=>$allOrder));
    }
    
    /**
     *   渲染管理员订单页面
     */
    public function actionAdminOrder()
    {
        return $this->render('adminorder');
    }
    
    /**
     *  管理员 管理所有订单页面
     */
    public function actionGetAdminOrder()
    {
        $id = yii::$app->request->post('id') == "" ? 0 : yii::$app->request->post('id');
        $allOrder = Order::getAdminOrder($id);
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
            $userObj = User::findOne($allOrder[$j]['user_id']);
            $allOrder[$j]['userinfo']['username'] = $userObj->username;
            $allOrder[$j]['userinfo']['phone']   = $userObj->phone;
            $allOrder[$j]['userinfo']['address'] = $userObj->address;
        }
        echo json_encode($allOrder);
        return;
    }
    
    /**
     *  接订单
     */
    public function actionAcceptOrder()
    {
        $id = yii::$app->request->post('id');
        $rs = Order::AcceptOrder($id);
        echo json_encode($rs);
        return;
    }
    
    /**
     *  退订单
     */
    public function actionBackOrder()
    {
        $id = yii::$app->request->post('id');
        $rs = Order::BackOrder($id);
        echo json_encode($rs);
        return;
    }
    
    /**
     *   渲染所有待发货页面
     */
    public function actionAppraise()
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
        return $this->render('appraise',array('allOrder'=>$allOrder));
    }
    
}

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
        return $this->render('index');
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
    
}

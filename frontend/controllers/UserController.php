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
     * 用户信息首页
     *
     * @return mixed
     */
	public function actionIndex()
    {
        return $this->render('index');
    }
    /**
    *  注册手机
    */
    public function actionTelRegister()
    {
        return $this->render('telregister');
    }
    /**
     *   个人信息详情页面
     */
    public function actionInfo()
    {
        $userId = yii::$app->user->id;
        $userObj = User::findOne($userId);
        return $this->render('info', ['user' => $userObj]);
    }
    
    /**
     *  绑定手机号
     */
    public function actionBindPhone()
    {
        $userId = yii::$app->user->id;
        $userObj = User::findOne($userId);
        if(yii::$app->request->ispost){
            $arrdess = yii::$app->request->post('phone');
            $userObj->phone = $arrdess;
            if($userObj->save()){
                $reInfo['code'] = 1;
                $reInfo['message'] = "";
                $reInfo['data'] = "";
            }else{
                $reInfo['code'] = -1;
                $reInfo['message'] = "绑定手机号";
                $reInfo['data'] = "";
            }
            echo json_encode($reInfo);
            return;
        }
        return $this->render('bindphone', ['user' => $userObj]);
    }
    
    /**
     *  修改地址
     */
    public function actionAddress()
    {
        $userId = yii::$app->user->id;
        $userObj = User::findOne($userId);
        if(yii::$app->request->ispost){
            $arrdess = yii::$app->request->post('address');
            $userObj->address = $arrdess;
            if($userObj->save()){
                $reInfo['code'] = 1;
                $reInfo['message'] = "";
                $reInfo['data'] = "";
            }else{
                $reInfo['code'] = -1;
                $reInfo['message'] = "保存地址失败";
                $reInfo['data'] = "";
            }
            echo json_encode($reInfo);
            return;
        }
        return $this->render('address', ['user' => $userObj]);
    }
    
    
}

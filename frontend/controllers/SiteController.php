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
use common\models\Goods;
use common\models\Sms;

/**
 * Site controller
 */
class SiteController extends Controller
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
        if(Yii::$app->user->isGuest)
        {
            $appid = yii::$app->params['APP_ID'];
            $REDIRECT_URI =  Yii::$app->request->hostInfo.Yii::$app->urlManager->createUrl('site/wx-call-back');
            //$scope='snsapi_base';
            $scope='snsapi_userinfo';//需要授权
            $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state=1#wechat_redirect';
            header("Location:".$url);
        }
        else{
            return $this->redirect(['site/home']);
        }
        
    }
    
    //项目主页面
    public function actionHome()
    {
        /*
         * 调试默认登陆一个用户*/
        $userId = 7;
        $userObj = User::findOne($userId);
        Yii::$app->user->login($userObj);
        
        
        //获取所有的热门推荐商品
        $indexShow = Goods::getAllShowGoods();
        return $this->render('home', ['show' => $indexShow]);
    }
    
    //微信回调页面
    public function actionWxCallBack()
    {
        $appid = yii::$app->params['APP_ID'];
        $secret = yii::$app->params['APP_SECRET'];
        $code = $_GET["code"];
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        $json_obj = tool::getCurl($get_token_url);
         
        $openid = $json_obj['openid'];
        $rs = User::getUserByWxid($openid);
        if($rs == "")
        {
            //微信登录的账号不存在，创建一个新账户
            $accessToken = BaseGlobal::getWxAccessToken();
            //获取用户的微信信息
            $wxInfo = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$accessToken.'&openid='.$openid.'&lang=zh_CN';
            $wxInfo_obj = tool::getCurl($wxInfo);
            //创建一个新用户
            $rs = User::addWxUser($wxInfo_obj);
            if($rs['code'] == 1)
            {
                //创建用户成功，用户自动登录，跳转首页
                $userId = $rs['data'];
                $userObj = User::findOne($userId);
                Yii::$app->user->login($userObj);
            }else{
                //创建用户失败
                return $this->render('error', [
                    'message' => "创建账户失败",
                ]);
            }
        }else{//用户登录成功
            Yii::$app->user->login($rs);
        }
        return $this->redirect(['site/home']);
    }
    
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    
    //发送验证码
    public function actionSendSms()
    {
        if(Yii::$app->request->isAjax)
        {
        	   $phone = yii::$app->request->post('phone');
        	   //1查看手机号是否已经被绑定
        	   $userObj = User::find()->where("phone != '' and phone=:phone",array(':phone'=>$phone))->one();
        	   if($userObj != "")
        	   {
        	       $reInfo['code'] = -1;
        	       $reInfo['message'] = "手机号已被绑定";
        	       $reInfo['data'] = "";
        	       echo json_encode($reInfo);
        	       return;
        	   }
        	   
        	   //2默认一分钟发送一次短信，判断发送短信请求是否合法
        	   $code = rand(10000, 99999);
        	   $ip = tool::getIp();
        	   $rs = Sms::addSms($phone,$code,$ip);
        	   if($rs['code'] == -1)
        	   {
        	       $reInfo['code'] = -1;
        	       $reInfo['message'] = $rs['message'];
        	       $reInfo['data'] = "";
        	       echo json_encode($reInfo);
        	       return;
        	   }
        	   //3发送短信验证
        	   $message = "您的验证码是：".$code;
        	   tool::sendPhoneMessage($phone, $message);
    
        	   $reInfo['code'] = 1;
        	   $reInfo['message'] = "";
        	   $reInfo['data'] = "";
        	   echo json_encode($reInfo);
        	   return;
        }
    }
    
    //检查验证码是否正确
    public function actionCheckSms()
    {
        $phone   = yii::$app->request->post('phone');
        $smsyzm  = yii::$app->request->post('smsyzm');
        $rs = Sms::checkSmsCode($phone, $smsyzm);
        if($rs['code'] == 1)
        {
            $userId = yii::$app->user->id;
            $userObj = User::findOne($userId);
            $userObj->phone = $phone;
            $userObj->save();
        }
        echo json_encode($rs);
        return;
    }
}

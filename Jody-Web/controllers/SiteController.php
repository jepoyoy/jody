<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\Employee;
use app\models\Driver;
use app\models\Route;
use app\models\Vehicle;
use app\models\Schedule;
use app\models\RouteReceipts;
use app\models\Trip;


class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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

    public function actionIndex()
    {

        if (\Yii::$app->user->isGuest) {
            return $this->render('index');
        }

        $user = \Yii::$app->user->identity;

        if ($user->isAdmin()) {

            $trips = Trip::find()->limit(10)->all();


            $yesterday = date('Y-m-d H:i:s',strtotime("-1 days"));
            $tomorrow = date('Y-m-d H:i:s',strtotime("tomorrow"));

            $todayreceipts = RouteReceipts::find()->andFilterWhere(['between', 'created_date', $yesterday, $tomorrow])->count();
            $todaytrips = Trip::find()->andFilterWhere(['between', 'created_date', $yesterday, $tomorrow])->count();


            return $this->render('index-admin',[
                    'trips' => $trips,
                    'todayreceipts' => $todayreceipts,
                    'todaytrips' => $todaytrips
                ]);
        }else{

            $vehicles = Vehicle::find()->all();
            $recently_receipts = RouteReceipts::find()
                                 ->where(['employee_id' => $user->employee_id])
                                 ->orderBy('created_date DESC')
                                 ->limit(5)
                                 ->all();

            return $this->render('index-user',[
                    'vehicles' => $vehicles,
                    'recently_receipts' => $recently_receipts,
                    'user' => $user
                ]);
        }

        
        return $this->render('index',[
            'user' => $user,
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}

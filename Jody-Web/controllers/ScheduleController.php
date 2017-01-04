<?php

namespace app\controllers;

use Yii;
use app\models\Schedule;
use app\models\ScheduleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * ScheduleController implements the CRUD actions for Schedule model.
 */
class ScheduleController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Schedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Schedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Schedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Schedule();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->schedule_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Schedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->schedule_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Schedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Schedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Schedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Schedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionSync(){
		
	
	$schedules= Schedule::find()->all();	
	$resp = array('response' => 'success', 'data' => $schedules);
		
		
	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	
	echo Json::encode($resp);
	Yii::$app->end(); 
	
     }


    public function actionRemind()
    {
        $schedules = Schedule::find()->all();

        foreach( $schedules as $schedule ){

            $model = $schedule;

            $now = date('Y-m-d H:i:s');

            $nowD = date('Y-m-d');

            $schedTime = date('Y-m-d H:i:s',strtotime( $nowD.' '.$model->trip_start ));

            $date_a = new \DateTime($now);
            $date_b = new \DateTime($schedTime);

            $interval = date_diff($date_a,$date_b);
            $minutes = intval( $interval->format('%i') );

            if($minutes > 5 || $minutes < 5){
                $this->remindSchedule($model->schedule_id);
            }

        }

    }

    protected function remindSchedule($id){
        $schedule = $this->findModel($id);

        foreach( $schedule->routeReceiptsToday as $passengerReceipt ){

            $service_url = 'http://'.$_SERVER['SERVER_NAME'].'/jody/web/index.php?r=sms/send&tel=<tel>&msg=<msg>';
            $service_url = str_replace("<tel>", $passengerReceipt->employee->mobile, $service_url);

            $txt =  "Hi ".$passengerReceipt->employee->Fullname.'. Your ride will start in 5 minutes. '.'http://'.$_SERVER['SERVER_NAME']; 
            $txt = $txt.(Url::toRoute(['qr/index', 'id' => $passengerReceipt->getPrimaryKey()]));
            $txt = urlencode($txt);

            $service_url = str_replace("<msg>", $txt, $service_url);
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $service_url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            $output = curl_exec($ch); 
            curl_close($ch);

        }

    }

}
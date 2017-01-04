<?php

namespace app\controllers;

use Yii;
use app\models\Trip;
use app\models\TripEmployee;
use app\models\TripSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;


/**
 * TripController implements the CRUD actions for Trip model.
 */
class TripController extends Controller
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
     * Lists all Trip models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TripSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Trip model.
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
     * Creates a new Trip model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Trip();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->trip_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Trip model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->trip_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Trip model.
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
     * Finds the Trip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Trip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trip::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     public function beforeAction($action)
    {      
        if ($action->id == 'sync') {
            Yii::$app->controller->enableCsrfValidation = false;
        }

        return true;

    }

    public function actionSync(){

        $jsonTripsToSync = Yii::$app->request->post('tripsToSync');


        $trips = json_decode($jsonTripsToSync,true);

        foreach($trips['trips'] as $trip){
               //print_r($trip);

               $tripObj = new Trip(); 
               $tripObj->notes = $trip['notes'];
               $tripObj->is_validity_enabled = $trip['isValidityEnabled'];
               $tripObj->created_date = $trip['createdDate'];
               $tripObj->updated_date = $trip['notes'];
               $tripObj->schedule_id = $trip['scheduleId'];
               $tripObj->route_id = $trip['routeId'];
               $tripObj->driver_id = $trip['driverId'];
               $tripObj->vehicle_id = $trip['vehicleId'];
               $tripObj->start_time = $trip['startTime'];
               $tripObj->end_time = $trip['endTime'];

               $tripObj->save();

               $tripid = $tripObj->getPrimaryKey();


               foreach($trip['passengers'] as $passenger){
                    //print_r($passenger);

                    $tripEmployee = new TripEmployee();
                    $tripEmployee->created_date = $passenger['createdDate'];
                    $tripEmployee->employee_id = $passenger['employeeId'];
                    $tripEmployee->trip_id = $tripid;
                    $tripEmployee->trip_receipt_id = $passenger['tripReceiptId'];

                    $tripEmployee->save();


               }

        }

        
        

        //print_r($trips);


        

    }

    public function actionTest(){

        return $this->render('test');

    }
}

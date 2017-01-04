<?php

namespace app\controllers;

use Yii;
use app\models\RouteReceipts;
use app\models\RouteReceiptsSearch;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RouteReceiptsController implements the CRUD actions for RouteReceipts model.
 */
class RouteReceiptsController extends Controller
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

    public function actionBook()
    {
        $data = Yii::$app->request->post();
        $model = new RouteReceipts();
        $model->employee_id = $data['emp_id'];
        $model->schedule_id = $data['sched_id'];
        $model->created_date = date('Y-m-d H:i:s');
        $model->save();

        //next example will recieve all messages for specific conversation
        $service_url = 'http://'.$_SERVER['SERVER_NAME'].'/jody/web/index.php?r=sms/send&tel=<tel>&msg=<msg>';
        $service_url = str_replace("<tel>", $model->employee->mobile, $service_url);

        $txt =  "Hi ".$model->employee->Fullname.'. This e-ticket confirms your booking. '.'http://'.$_SERVER['SERVER_NAME']; 
        $txt = $txt.(Url::toRoute(['qr/index', 'id' => $model->getPrimaryKey()]));
        $txt = urlencode($txt);

        $service_url = str_replace("<msg>", $txt, $service_url);
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $service_url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        $output = curl_exec($ch); 
        curl_close($ch);

        return $this->redirect(
            [
                '/route-receipts/view-user',
                'id' => $model->getPrimaryKey()
            ]
        );
    }

    /**
     * Lists all RouteReceipts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RouteReceiptsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RouteReceipts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewUser($id)
    {
        return $this->render('view-user', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RouteReceipts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RouteReceipts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->trip_receipt_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RouteReceipts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->trip_receipt_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RouteReceipts model.
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
     * Finds the RouteReceipts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RouteReceipts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RouteReceipts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

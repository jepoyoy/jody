<?php

namespace app\controllers;

use app\models\Employee;
use app\models\Driver;
use app\models\Route;
use app\models\Vehicle;
use app\models\Schedule;
use app\models\RouteReceipts;
use app\models\Trip;


class ReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDailyReport()
    {

    	$this->layout = false;

    	$yesterday = date('Y-m-d H:i:s',strtotime("-1 days"));
    	$tomorrow = date('Y-m-d H:i:s',strtotime("tomorrow"));

    	$trips = Trip::find()->andFilterWhere(['between', 'created_date', $yesterday, $tomorrow])->all();

    	
        header("Pragma: no-cache"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false); // required for certain browsers
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment; filename=\"daily-report-".date('Y-m-d').".doc");
        header("Content-Transfer-Encoding: binary");

        return $this->render('daily-report',[
                    'trips' => $trips,
                    'yesterday' => $yesterday,
                    'tomorrow' => $tomorrow
                ]);
    }

}

<?php

namespace app\controllers;

use Yii;
use Endroid\QrCode\QrCode;
use app\models\RouteReceipts;
use app\aes\AES;

class QrController extends \yii\web\Controller
{
    public function actionIndex($id)
    {

    	$tripReceipt = RouteReceipts::findOne($id);

    	$user = \Yii::$app->user->identity;

    	if( $tripReceipt->employee->employee_id == $user->employee_id || $user->isAdmin() ){
    		



    	$str = '{"trip_receipt_id":"<trip_receit_id>","schedule_id":"<schedule_id>","trip_start":"<trip_start>","route_id":"<route_id>","route_code":"<route_code>","receipt_date":"<date>","employee_id":"<eid>"}';

    	$str = str_replace("<trip_receit_id>", $tripReceipt->trip_receipt_id, $str);
    	$str = str_replace("<schedule_id>", $tripReceipt->schedule_id, $str);
    	$str = str_replace("<trip_start>", $tripReceipt->schedule->trip_start, $str);
    	$str = str_replace("<route_id>", $tripReceipt->schedule->route_id, $str);
    	$str = str_replace("<route_code>", $tripReceipt->schedule->route->route_code, $str);
    	$str = str_replace("<date>", $tripReceipt->created_date, $str);
    	$str = str_replace("<eid>", $tripReceipt->employee->employee_id, $str);

    	$fulldatenow = date('Y-m-d', strtotime($tripReceipt->created_date));
    	$datestart =  $tripReceipt->schedule->trip_start . ' ' . $fulldatenow; 
		$dateceipte = date('Y-m-d h:i:s a', strtotime($datestart));

		$inputKey = "57238004e784498bbc2f8bf984565090";
		$aes = new AES();
		$enc = $aes->encrypt($str, $inputKey);
		$dec=$aes->decrypt(strtoupper($enc), $inputKey);
	
	header("Content-type: image/png");

        if(isset($_GET["download"])){
            header('Content-Disposition: attachment; charset=UTF-8; filename="'.$dateceipte.'-'.$tripReceipt->employee->email.'.png"');
        }

    	$qrCode = new QrCode();
		$qrCode
		    ->setText(strtoupper($enc))
		    ->setSize(300)
		    ->setPadding(10)
		    ->setErrorCorrection('high')
		    ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
		    ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
		    ->setLabel($dateceipte)
		    ->setLabelFontSize(16)
		    ->render();

       
        }else{
            echo "Access Denied - Invalid User viewing receipt";
        }

        
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->end();      
    }

}
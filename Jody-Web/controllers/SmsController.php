<?php
namespace app\controllers;

use Yii;

class SmsController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$pushbullet = new \Pushbullet\Pushbullet('o.9I5UgJZGqdXuKiyYsHa0cFDaspPBbMm3');
        return $this->render('index', [
            'devices' => $pushbullet->getDevices()
        ]);
    }

    public function actionSend($tel, $msg)
    {

        \Pushbullet\Connection::setCurlCallback(function ($curl) {
            // Get a CA certificate bundle here:
            // https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
            //curl_setopt($curl, CURLOPT_CAINFO, 'C:/path/to/ca-bundle.crt');

            // Not recommended! Makes communication vulnerable to MITM attacks:
             curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        });

    	$pb = new \Pushbullet\Pushbullet('o.9I5UgJZGqdXuKiyYsHa0cFDaspPBbMm3');

		$pb->device("Dev1-Globe")->sendSms($tel, $msg);

        return $this->render('index', [
            'devices' => $pb->getDevices()
        ]);
    }

}

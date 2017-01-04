<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Trip */

$this->title = $model->trip_id;
$this->params['breadcrumbs'][] = ['label' => 'Trips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-view">

    <h1>Trip # <?= $model->trip_id ?></h1>

    <?php

        $trip = $model;

      $route = $trip->route;
      $route_code0 = $route->CodeAsArray[0];
      $route_code1 = $route->CodeAsArray[1];

      $datestart =  $trip->schedule->trip_start . '02/20/1991'; 


       $dateend =  $trip->schedule->trip_end . '02/20/1991'; 
    ?>

      <div class="panel panel-default finished-trip">
      <div class="panel-body">
        
        <div class="col-sm-2">
            <img src="<?= Yii::$app->request->baseUrl . "/images/rt/rt-$route_code0.jpg"; ?>" alt="Infor Office" class="img-rounded">
            <img src="<?= Yii::$app->request->baseUrl . "/images/rt/rt-rw.jpg"; ?>" alt="->" class="img-rounded">
            <img src="<?= Yii::$app->request->baseUrl . "/images/rt/rt-$route_code1.jpg"; ?>" alt="Market Market" class="img-rounded">
        </div>

        <div class="col-sm-10">
            <dl style="margin-bottom:0px">
              <dt><?= $route->pointA ?> to <?= $route->pointB ?></dt>
              <dd style="font-size:0.8em"><?php echo date('h:i:s a', strtotime($datestart)); ?> - <?php echo date('h:i:s a', strtotime($dateend)); ?></dd>
              <dd style="font-size:0.8em"><?= $trip->driver->lname ?> , <?= $trip->driver->fname ?></dd>
            </dl>
        </div>

      </div>
    </div>

    <h4>Passenger List</h4>

    <table class="table">

        <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Trip Receipt</th>
            <th>Sched Match Check</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach( $trip->tripEmployees as $passenger ): ?>

                <tr>
                    <td><?= $passenger->trip_employee_id ?></td>
                    <td><?= $passenger->employee->fullname ?></td>
                    <td><?= $passenger->employee->email ?></td>
                    <td><a href="<?= urldecode(Url::toRoute(['qr/index', 'id' => $passenger->trip_receipt_id])); ?>" class="btn btn-primary btn-lg active" role="button">Link</a></td>
                    <td><?php

                        //checks if the original intended sched is used

                    $receipt_sched = $passenger->tripReceipt->schedule->schedule_id;
                    $trip_sched = $trip->schedule->schedule_id;

                    if( $receipt_sched == $trip_sched ){
                        echo '<span class="label label-success">No Issues</span>';
                    }else{
                        echo '<span class="label label-warning">With Issue</span>';
                    }

                    ?></td>

                </tr>


            <?php endforeach ?>
        </tbody>

    </table>

</div>

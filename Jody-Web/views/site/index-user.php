<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

    	      <div class="row">
          <section id="asdasd" class="col-md-12">
          <i>System Time: <?= date('Y-m-d H:i:s'); ?></i>
          </section>
        </div>

        <div class="row">
		  <div class="col-xs-12 col-md-8">

		  	<h3>Book tickets here</h3>

		  	<!-- This is where the shuttles and schedules will show up -->

		  	<?php foreach($vehicles as $vehicle): ?>

		  	<div class="panel panel-default">
			  <!-- Default panel contents -->
			  <div class="panel-heading"><?= $vehicle->platenum ?> - <?= $vehicle->description ?></div>

			  <!-- Table -->
			  <table class="table">

			  	<thead>
			  		<th>Pickup</th>
			  		<th>Drop-off</th>
			  		<th>Pickup time</th>
			  		<th>Estimated Drop-off time</th>
			  		<th></th>
			  	</thead>

			  	<tbody>

			  		<?php foreach($vehicle->schedules as $schedule): ?>

			  			<tr>
			  			<td><?= $schedule->route->pointA ?></td>
			  			<td><?= $schedule->route->pointB ?></td>
			  			<td><?php 
			  				$datestart =  $schedule->trip_start . '02/20/1991'; 
							echo date('h:i:s a', strtotime($datestart));
			  			?></td>
			  			<td><?php 
			  				$dateend =  $schedule->trip_end . '02/20/1991'; 
							echo date('h:i:s a', strtotime($dateend));
			  			?></td>
			  			<td><a href="#" onclick="javascript:modalBT('<?= $schedule->schedule_id ?>')">Book schedule</a></td>
			  			</tr>

			  			<script type="text/javascript">

			  				var sched_obj = new Schedule(
			  						'<?= $schedule->schedule_id ?>',
			  						'<?= date('h:i:s a', strtotime($datestart)) ?>',
			  						'<?= $schedule->route->pointA ?>',
			  						'<?= date('h:i:s a', strtotime($dateend)) ?>',
			  						'<?= $schedule->route->pointB ?>',
			  						'<?= $schedule->route->route_code ?>',
			  						'<?= $vehicle->VehicleDesc ?>'
			  					);

			  				SCHED_MAP.put(sched_obj.schedule_id, sched_obj);

			  			</script>

			  		<?php endforeach; ?>

			  	</tbody>

			  </table>
			</div>

		    <?php endforeach;  ?>

		  	

		  </div>
		  
		  <div class="col-xs-12 col-md-4">

		  	<h3>&nbsp;</h3>

		  	<div class="panel panel-default">
			  <div class="panel-heading">Your recently booked rides</div>
			  <div class="panel-body">
			   		
			   		<div class="list-group">
					 

					  	<?php foreach($recently_receipts as $receipt): ?>

					  	<a href="<?= urldecode(Url::toRoute(['route-receipts/view-user', 'id' => $receipt->trip_receipt_id])); ?>" class="list-group-item">
					  	<?php

					  	$route = $receipt->schedule->route;
					  	$route_code = $route->CodeAsArray[1];


					  	$fulldatenow = date('Y-m-d', strtotime($receipt->created_date));
				    	$datestart =  $receipt->schedule->trip_start . ' ' . $fulldatenow; 
						$dateceipte = date('Y-m-d', strtotime($datestart));
						$timereceipt = date('h:i:s a', strtotime($datestart));

					  	?>

					  	<div class="row">
						  <div class="col-md-3">
						  	<img src="<?= Yii::$app->request->baseUrl . "/images/rt/rt-$route_code.jpg"; ?>" alt="Infor Office" class="img-rounded">
						  </div>
						  <div class="col-md-9">
						  	<h5 class="list-group-item-heading"><b><?= $route->RouteDesc ?></b></h5>
					   		<p style="font-size:0.8em" class="list-group-item-text"><?= $dateceipte ?></p>
					   		<p style="font-size:0.8em"><i><?= $timereceipt ?></i></p>
						  </div>
						</div>
						
						</a>
						<?php endforeach; ?>

						<br/>

						
					</div>

			  </div>
			</div>

		  </div>
		</div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="booking-confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirm your e-ticket details</h4>
      </div>
      <form method="POST" action="<?= urldecode(Url::toRoute(['route-receipts/book'])); ?>">
      <div class="modal-body">
        
        
          <div class="form-group">
		    <label for="s">Your Shuttle vehicle info</label>
		    <input type="text" class="form-control" id="vehicle-info" placeholder="s">
		  </div>
		  <div class="form-group">
		    <label for="b">Booking Route</label>
		    <input type="text" class="form-control" id="book-route" placeholder="b">
		  </div>
		  <div class="form-group">
		    <label for="p">Pickup / Estimated Dropoff time</label>
		    <input type="text" class="form-control" id="pickup-dropoff" placeholder="p">
		  </div>
			
		 <input type="hidden" id="emp_id" name="emp_id" value="<?= $user->employee_id ?>" />
		 <input type="hidden" name="sched_id" id="sched_id" />
		 <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default">Confirm Booking</button>
      </div>
      </form>
    </div>
  </div>
</div>
